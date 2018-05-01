<?php declare(strict_types = 1);

namespace App\Command;

use App\Entity\Product;
use App\Value\Price;
use App\Value\TaxRate;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use function fclose;
use function fgetcsv;
use function file_exists;
use function fopen;
use function is_readable;
use const PHP_EOL;

final class ImportCommand extends Command
{
    private const BATCH_SIZE = 2;

    private $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        parent::__construct();

        $this->doctrine = $doctrine;
    }

    protected function configure()
    {
        $this
            ->setName('products:import')
            ->addArgument('file', InputArgument::REQUIRED, 'Location of the CSV-file to read products from.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filename = $input->getArgument('file');


        $io = new SymfonyStyle($input, $output);
        $io->title('Product Importer');
        $io->text([
            'Reads a CSV file and imports the contained products into our database.',
            'This command will alter your database! Please be careful when using it in production.',
        ]);

        if(!file_exists($filename) || !is_readable($filename)) {
            $io->error(sprintf('The provided filename "%s" is not readable!', $filename));

            return 1;
        }

        /** @var EntityManager $entityManager */
        $entityManager = $this->doctrine->getManagerForClass(Product::class);
        $handle = fopen($filename, 'rb');
        $io->newLine();
        $name = '.';
        while (($row = fgetcsv($handle)) !== false) {
            $product= new Product(
                $row[0],
                $row[1],
                Price::fromCents((int) $row[2]),
                new TaxRate((int) $row[3])
            );
            if ($io->isVerbose()) {
                $name = (string) $product . PHP_EOL;
            }
            $io->write($name);

            $entityManager->persist($product);
        }
        fclose($handle);
        $entityManager->flush();
        $io->newLine();
        $io->success('Finished importing products.');

        return 0;
    }
}

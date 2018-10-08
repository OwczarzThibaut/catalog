<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Repository\ProductRepository;
use App\Entity\ProductInterface;

class ProductsCsvCommand extends Command
{
    protected static $defaultName = 'app:products:csv';
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Get All products format csv')
            ->addOption('product_id', null, InputOption::VALUE_OPTIONAL, 'Pour n\'avoir qu\'un produit')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        if ($input->getOption('product_id')) {
            $product_id = $input->getOption('product_id');
            $products = [$this->productRepository->findById($product_id)];
        } else {
            $products = $this->productRepository->findAll();
        }

        /* TODO set this to services.yaml in parameters */
        $fileCSV = "./public/products.csv";
        $fileCSV_url = "http://localhost:8000/products.csv";

        $handle = fopen($fileCSV, 'w+');
        fputcsv($handle, ['id', 'nom', 'description', 'image', 'slug']);
        foreach ($products as $product) {
            if ($product instanceof ProductInterface) {
                fputcsv($handle, $product->toArray());
            }
        }
        fclose($handle);

        $io->success('Success Export created.');
        $io->note('Go to this url '.$fileCSV_url);
    }
}

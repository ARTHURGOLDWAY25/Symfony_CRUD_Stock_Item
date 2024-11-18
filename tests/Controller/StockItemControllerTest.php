<?php

namespace App\Test\Controller;

use App\Entity\StockItem;
use App\Repository\StockItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StockItemControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private StockItemRepository $repository;
    private string $path = '/stock/item/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(StockItem::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('StockItem index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'stock_item[name]' => 'Testing',
            'stock_item[quantity]' => 'Testing',
            'stock_item[price]' => 'Testing',
            'stock_item[description]' => 'Testing',
            'stock_item[createdAt]' => 'Testing',
            'stock_item[updatedAt]' => 'Testing',
        ]);

        self::assertResponseRedirects('/stock/item/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new StockItem();
        $fixture->setName('My Title');
        $fixture->setQuantity('My Title');
        $fixture->setPrice('My Title');
        $fixture->setDescription('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('StockItem');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new StockItem();
        $fixture->setName('My Title');
        $fixture->setQuantity('My Title');
        $fixture->setPrice('My Title');
        $fixture->setDescription('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'stock_item[name]' => 'Something New',
            'stock_item[quantity]' => 'Something New',
            'stock_item[price]' => 'Something New',
            'stock_item[description]' => 'Something New',
            'stock_item[createdAt]' => 'Something New',
            'stock_item[updatedAt]' => 'Something New',
        ]);

        self::assertResponseRedirects('/stock/item/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getQuantity());
        self::assertSame('Something New', $fixture[0]->getPrice());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new StockItem();
        $fixture->setName('My Title');
        $fixture->setQuantity('My Title');
        $fixture->setPrice('My Title');
        $fixture->setDescription('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/stock/item/');
    }
}

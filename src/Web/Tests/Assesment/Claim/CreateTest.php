<?php

declare(strict_types=1);

namespace App\Web\Tests\Assesment\Claim;

use Assessment\Domain\AssessmentType;
use Assessment\Domain\Claim\Claim;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\User\InMemoryUserProvider;

class CreateTest extends WebTestCase
{
    private const string URL = '/assessment/claim/create';

    public function testRedirectIfNotAuthenticated(): void
    {
        $client = static::createClient();

        $client->request('GET', self::URL);

        $this->assertResponseRedirects('/login', 302);
    }


    public function testFormDisplayed(): void
    {
        $client = $this->createAuthorizedClient();

        $client->request('GET', self::URL);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('#assessment-type');
        $this->assertSelectorExists('#email');
        $this->assertSelectorExists('#price');
        $this->assertSelectorExists('#form_submit');
    }

    public function testFailedValidationOnSubmit(): void
    {
        $client = $this->createAuthorizedClient();

        $client->request('GET', self::URL);

        $client->enableProfiler();
        $client->submitForm('form_submit');

        $this->assertEquals(0, $this->getClaimRepository()->count([]));
    }

    public function testSuccessSubmit(): void
    {
        $client = $this->createAuthorizedClient();

        $crawler = $client->request('GET', self::URL);
        $form = $crawler->selectButton('Отправить')->form();

        $form->setValues([
            'form[assessment_type]' => AssessmentType::Auto->value,
            'form[email]' => 'test@test.ru'
        ]);

        $client->submit($form);

        $this->assertEquals(1, $this->getClaimRepository()->count([]));
    }

    private function getClaimRepository(): EntityRepository
    {
        return static::getContainer()->get('doctrine')->getRepository(Claim::class);
    }

    private function createAuthorizedClient(): KernelBrowser
    {
        $userProvider = new InMemoryUserProvider([
            'admin' => ['password' => '1234', 'roles' => ['ROLE_ADMIN']]
        ]);
        $user = $userProvider->loadUserByIdentifier('admin');

        return static::createClient()
            ->loginUser($user);
    }
}

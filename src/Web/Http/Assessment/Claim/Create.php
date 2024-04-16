<?php

declare(strict_types=1);

namespace App\Web\Http\Assessment\Claim;

use Assessment\Services\AssessmentServiceInterface;
use Assessment\UseCases\Claim\Create\CreateClaim;
use Lib\Application\Command\CommandBusInterface;
use Lib\Serializer\DenormalizerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Twig\Environment;

#[
    Route(
        path: '/assessment/claim/create',
        name: 'assessment.claim.create',
        methods: ['GET', 'POST']
    ),
]
final readonly class Create
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private FormFactoryInterface $formFactory,
        private Environment $twig,
        private DenormalizerInterface $denormalizer,
        private UrlGeneratorInterface $urlGenerator,
        private AssessmentServiceInterface $assessmentService,
    ) {

    }

    public function __invoke(#[CurrentUser] $user, Request $request): Response
    {
        $assessmentNames = $this->assessmentService->getNameList();
        $prices = $this->assessmentService->getPriceList();

        $form = $this->formFactory->createBuilder()
            ->add(
                'assessment_type',
                ChoiceType::class,
                [
                    'required' => true,
                    'label' => 'Услуга',
                    'choices' => array_flip($assessmentNames)
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'required' => true,
                    'label' => 'Почта',
                ]
            )
            ->add(
                'price',
                TextType::class,
                [
                    'label' => 'Цена',
                    'disabled' => true,
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Отправить',
                ]
            )
            ->getForm()
        ;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $createClaimCommand = $this->denormalizer->denormalize($form->getData(), CreateClaim::class);
            $this->commandBus->dispatch($createClaimCommand);

            return new RedirectResponse(
                $this->urlGenerator->generate('assessment.claim.create')
            );
        }


        return new Response(
            $this->twig->render('create-claim.html.twig',
                [
                    'form' => $form->createView(),
                    'prices' => $prices,
                ]
            )
        );
    }
}

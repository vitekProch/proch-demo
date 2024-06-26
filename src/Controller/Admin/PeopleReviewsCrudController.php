<?php

namespace App\Controller\Admin;

use App\EasyAdmin\Fields\MultipleImageField;
use App\EasyAdmin\Fields\ImageUploadHelper;
use App\EasyAdmin\Helpers\ActionHelper;
use App\Entity\PeopleReviews;
use App\Repository\PeopleReviewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\BatchActionDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Response;


class PeopleReviewsCrudController extends AbstractCrudController
{
    private PeopleReviewsRepository $peopleReviewsRepository;
    private ImageUploadHelper $uploadHelper;
    private ActionHelper $actionHelper;

    public static function getEntityFqcn(): string
    {
        return PeopleReviews::class;
    }

    public function __construct(PeopleReviewsRepository $peopleReviewsRepository, ImageUploadHelper $uploadHelper, ActionHelper $actionHelper)
    {
        $this->peopleReviewsRepository = $peopleReviewsRepository;
        $this->uploadHelper = $uploadHelper;
        $this->actionHelper = $actionHelper;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $this->actionHelper->changeActionsLabel($actions);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setPageTitle('index','Recenze')
            ->setPageTitle('edit','Uprav recenzi')
            ->setPageTitle('new','Přidej recenzi');
    }

    public function createEntity(string $entityFqcn): PeopleReviews
    {
        $review = new PeopleReviews();
        $review->setReviewAlt("Screenshot");

        return $review;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->onlyOnIndex();

        yield ImageField::new('ReviewPhotoName', 'Obrázek recenze')
            ->hideWhenCreating()
            ->setBasePath('uploads/reviews')
            ->setUploadDir('public/uploads/reviews');

        yield MultipleImageField::new('ReviewPathFile', "Přidej recenze")
            ->setRequired(true)
            ->setFormTypeOption('multiple', true);

        yield TextField::new('reviewAlt', 'Alternativní text');
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $filesArray = parent::getContext()->getRequest()->files->get('PeopleReviews')['ReviewPathFile'];
        foreach($filesArray as $file)
        {
            $uniqueImageName = $this->uploadHelper->generateUniqueFileName($file->getClientOriginalName());
            $peopleReviews = (new PeopleReviews())
                ->setReviewAlt($entityInstance->getReviewAlt())
                ->setReviewPhotoName($uniqueImageName);

            $this->uploadHelper->upload($file, $uniqueImageName, 'uploads/reviews');
            $entityManager->persist($peopleReviews);
        }
        $entityManager->flush();
    }

    public function batchDelete(AdminContext $context, BatchActionDto $batchActionDto): Response
    {
        foreach ($batchActionDto->getEntityIds() as $entityId) {
            $entityToRemove = $this->peopleReviewsRepository->find($entityId);
            $reviewToRemovePath = $entityToRemove->getReviewPhotoPath();
            $this->uploadHelper->deletePhotoFromDirectory($reviewToRemovePath);
        }
        return parent::batchDelete($context, $batchActionDto);
    }

    public function delete(AdminContext $context): Response
    {
        $imgPath = $context->getEntity()->getInstance()->getReviewPathFile();
        $this->uploadHelper->deletePhotoFromDirectory($imgPath);
        return parent::delete($context);
    }

}

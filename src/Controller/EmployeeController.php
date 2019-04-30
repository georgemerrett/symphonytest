<?php
// src/Controller/EmployeeController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Employee;

class EmployeeController extends AbstractController
{    
    public function show()
    {
        $repo = $this->getDoctrine()
        ->getRepository(Employee::class)
        ->findAll();
        
        $emparr = Array();
        
        // Rebuild employees array but get date as a string
        foreach($repo as $emp)
        {
            $stdemp = new \stdClass();
            $stdemp->birthdate = $emp->getBirthdateString();
            $stdemp->firstname = $emp->getFirstname();
            $stdemp->lastname = $emp->getLastname();
            $stdemp->email = $emp->getEmail();
            array_push($emparr, $stdemp);
        }

        return $this->render('user/view.html.twig', ['users' => $emparr]);    
    }
    
    public function new(Request $request)
    {
        $user = new Employee();

        $form = $this->createFormBuilder($user)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('birthDate', DateType::class, array(
                 'widget' => 'choice',
                 'years' => range(date('Y'), date('Y')-100)
               ))
            ->add('email', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Submit'])
            ->getForm();
            
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $user = $form->getData();
            
            // you can fetch the EntityManager via $this->getDoctrine()
            // or you can add an argument to your action: index(EntityManagerInterface $entityManager)
            $entityManager = $this->getDoctrine()->getManager();
    
            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($user);
    
            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
    
            $this->addFlash('success','New employee was created successfully!');
        }
        
        return $this->render('user/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
?>
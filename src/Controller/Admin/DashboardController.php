<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('S01 Forum');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('Forum', 'fas fa-list-alt'),
            MenuItem::linkToCrud('Categories', 'fas fa-list-alt', category::class),

            MenuItem::section('Gestion des utilisateurs'),
            MenuItem::linkToCrud('Utilisateur', 'fas fa-list-alt', User::class),
        ];
    }
}

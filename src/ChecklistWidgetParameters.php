<?php

namespace MorgenBord\ChecklistWidgetBundle;

use App\Entity\Widget;
use App\Event\RegisterWidgetEvent;
use App\Interfaces\ParametersFormTypeInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ChecklistWidgetParameters implements ParametersFormTypeInterface
{
    public const WIDGET_NAME = 'Checklist';
    public const WIDGET_SHORT_NAME = 'checklist_widget';
    public const TWIG_FILE = '@ChecklistWidget/widget.html.twig';

    public function onMorningBordRegisterWidget(RegisterWidgetEvent $event)
    {
        $widget = new Widget();
        $widget->setName(self::WIDGET_NAME);
        $widget->setShortName(self::WIDGET_SHORT_NAME);
        $widget->setTwigFile(self::TWIG_FILE);
        $widget->setParameterFormFqcn(ChecklistWidgetBundle::class);
        
        $event->addWidget($widget);
    }
    
    public function createParametersForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'List name',
                'required' => false,
            ])
        ;
    }
}
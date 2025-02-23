<?php

namespace Morgenbord\ChecklistWidgetBundle;

use Morgenbord\CoreBundle\Entity\Widget;
use Morgenbord\CoreBundle\Event\RegisterWidgetEvent;
use Morgenbord\CoreBundle\Interfaces\ParametersFormTypeInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class MorgenbordChecklistWidgetParameters implements ParametersFormTypeInterface
{
    public const WIDGET_NAME = 'Checklist';
    public const WIDGET_SHORT_NAME = 'checklist_widget';
    public const TWIG_FILE = '@MorgenbordChecklistWidget/widget.html.twig';

    public function onMorningBordRegisterWidget(RegisterWidgetEvent $event)
    {
        $widget = new Widget();
        $widget->setName(self::WIDGET_NAME);
        $widget->setShortName(self::WIDGET_SHORT_NAME);
        $widget->setTwigFile(self::TWIG_FILE);
        $widget->setParameterFormFqcn(MorgenbordChecklistWidgetBundle::class);
        
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
<?php
namespace Clientes\Form;

use Zend\Form\Form;

class ClientesForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('clientes');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'nome',
            'type' => 'text',
            'options' => [
                'label' => 'Nome',
            ],
        ]);
        $this->add([
            'name' => 'funcao',
            'type' => 'text',
            'options' => [
                'label' => 'Função',
            ],
        ]);
        $this->add([
            'name' => 'idade',
            'type' => 'text',
            'options' => [
                'label' => 'Idade',
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}
?>
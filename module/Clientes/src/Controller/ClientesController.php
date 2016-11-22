<?php
namespace Clientes\Controller;

use Clientes\Model\ClientesTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Clientes\Form\ClientesForm;
use Clientes\Model\Clientes;

class ClientesController extends AbstractActionController
{

    
    private $table;

    public function __construct(ClientesTable $table)
    {
        $this->table = $table;
    }
    public function indexAction()
    {
          return new ViewModel([
            'clientes' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
        $form = new ClientesForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $clientes = new Clientes();
        $form->setInputFilter($clientes->getInputFilter());
        $form->setData($request->getPost());

        //Caso o formulário não seja válido ele será reapresentado
        if (! $form->isValid()) {
            return ['form' => $form];
        }
        // Caso o formulário seja válido é armazenado na model com o comando saveClientes
        $clientes->exchangeArray($form->getData());
        $this->table->saveClientes($clientes);
        
        return $this->redirect()->toRoute('clientes');
    }
    // Método que chama a edição de um registro
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('clientes', ['action' => 'add']);
        }

        try {
            $clientes = $this->table->getClientes($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('clientes', ['action' => 'index']);
        }

        $form = new ClientesForm();
        $form->bind($clientes);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($clientes->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveClientes($clientes);

        // Redireciona a lista de Clientes
        return $this->redirect()->toRoute('clientes', ['action' => 'index']);
    }
    // Método para deletar registro do banco de dados
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('clientes');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteClientes($id);
            }

            // Redireciona para lista de Clientes
            return $this->redirect()->toRoute('clientes');
        }

        return [
            'id'    => $id,
            'clientes' => $this->table->getClientes($id),
        ];
    }
    
}
?>
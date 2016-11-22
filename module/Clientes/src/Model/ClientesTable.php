<?php
namespace Clientes\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class ClientesTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getClientes($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveClientes(Clientes $clientes)
    {
        $data = [
            'nome' => $clientes->nome,
            'funcao'  => $clientes->funcao,
            'idade'  => $clientes->idade,
        ];

        $id = (int) $clientes->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getClientes($id)) {
            throw new RuntimeException(sprintf(
                'Não é possível atualizar com o seguinte id %d; Ele não existe no banco de dados',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteClientes($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}
?>
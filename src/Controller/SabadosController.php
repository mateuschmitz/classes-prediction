<?php

namespace Application\Controller;

class SabadosController extends \Phalcon\Mvc\Controller
{
    public function index()
    {
        return $this->view->render('sabados', 'index');
    }

    public function adicionar()
    {
        if ($this->request->isPost()) {

            try {
                $dados = $this->request->getPost();
                if (empty($dados['data'])) {
                    $this->flashSession->error("Por favor, informe a data correta!");
                    return $this->response->redirect($this->request->getHTTPReferer());
                }

                $data = \DateTime::createFromFormat('d/m/Y', $dados['data']);
                $sabado = (new \Application\Model\DiaExtraLetivo())
                    ->setData($data->format('Y-m-d'))
                    ->setCreated(date('Y-m-d H:i:s'));

                if ($sabado->create() == false) {
                    throw new \UnexpectedValueException("Não foi possível salvar o sábado letivo!");
                }
            } catch (\Exception $e) {
                $this->flashSession->error($e->getMessage());
                return $this->response->redirect($this->request->getHTTPReferer());
            }

            $this->flashSession->success("Sábado salvo com sucesso!");
            return $this->response->redirect($this->request->getHTTPReferer());
        }

        return $this->view->render('sabados', 'adicionar');
    }

    public function editar($id)
    {
        $sabado = \Application\Model\DiaExtraLetivo::findFirst($id);
        if (!$sabado) {
            $this->flashSession->error("Sábado não encontrado!");
            return $this->response->redirect($this->request->getHTTPReferer());
        }

        if ($this->request->isPost()) {

            try {
                $dados = $this->request->getPost();
                if (empty($dados['data'])) {
                    $this->flashSession->error("Por favor, informe a data correta!");
                    return $this->response->redirect($this->request->getHTTPReferer());
                }

                $data = \DateTime::createFromFormat('d/m/Y', $dados['data']);
                $sabado->setData($data->format('Y-m-d'));

                if ($sabado->update() == false) {
                    throw new \UnexpectedValueException("Não foi possível alterar o sábado letivo!");
                }
            } catch (\Exception $e) {
                $this->flashSession->error($e->getMessage());
                return $this->response->redirect($this->request->getHTTPReferer());
            }

            $this->flashSession->success("Sábado alterado com sucesso!");
            return $this->response->redirect($this->request->getHTTPReferer());
        }

        $this->view->sabado = $sabado;
        return $this->view->render('sabados', 'editar');
    }

    public function excluir($id)
    {
        $sabado = \Application\Model\DiaExtraLetivo::findFirst($id);
        if (!$sabado) {
            $this->flashSession->error("Sábado não encontrado!");
            return $this->response->redirect($this->request->getHTTPReferer());
        }

        try {
            if ($sabado->delete() == false) {
                throw new \UnexpectedValueException("Não foi possível deletar o sábado!");
            }
        } catch (\Exception $e){
            $this->flashSession->error($e->getMessage());
            return $this->response->redirect($this->request->getHTTPReferer());
        }

        $this->flashSession->success("Sábado deletado com sucesso!");
        return $this->response->redirect($this->request->getHTTPReferer());
    }
}
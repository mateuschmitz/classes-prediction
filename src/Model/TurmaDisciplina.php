<?php

namespace Application\Model;

class TurmaDisciplina extends BaseModel
{
    protected $turmaId;

    protected $disciplinaId;

    public function initialize()
    {
        $this->setSource('turmas_disciplinas');
        $this->belongsTo('turmaId', __NAMESPACE__ . '\\Turma', 'id', array('alias' => 'turma'));
        $this->belongsTo('disciplinaId', __NAMESPACE__ . '\\Disciplina', 'id', array('alias' => 'disciplina'));
    }

    public function validation()
    {
        return $this->validationHasFailed() != true;
    }
}
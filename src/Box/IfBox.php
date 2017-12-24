<?php

namespace Avtomat\Box;

use Avtomat\Contracts\BoxContract;
use Avtomat\DependencyInjection\DI;
use Avtomat\Utils\StrUtil;

/**
 * Условие
 */
class IfBox extends Box implements BoxContract
{
    public $title = 'If';

    public function run()
    {
        StrUtil::debug('Блок условия');
        $comparator = $this->getController()->call($this, 'comparator');
        $self = $this;
        $result = $self->getResultsStorage()->read($comparator);
        $gotoLabel = $result ? 'then' : 'else';
        $this->getController()->go($this, $gotoLabel, function($output) use ($self, $comparator, $result) {
            $self->getInputsStorage()->write(
                $output,
                $result
            );
        });
    }
}
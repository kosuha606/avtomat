<?php

namespace Avtomat\Box;

use Avtomat\Contract\BoxContract;
use Avtomat\DependencyInjection\DI;
use Avtomat\Util\StrUtil;

/**
 * Условие
 */
class IfBox extends Box implements BoxContract
{
    public $inputLabels = ['input', 'comparator'];

    public $outputLabels = ['then', 'else'];

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
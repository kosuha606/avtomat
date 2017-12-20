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
    public function run($inputData)
    {
        StrUtil::writeln('Блок условия');
        $comparator = $this->getController()->call($this, 'comparator');
        $self = $this;
        $this->getController()->go($this, 'output', function($output) use ($self, $comparator) {
            $self->getInputsStorage()->write(
                $output,
                (string)$self->getResultsStorage()->read($comparator)
            );
        });
    }
}
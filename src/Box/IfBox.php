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
    public function run()
    {
        StrUtil::writeln('Блок условия');
        $comparator = $this->getController()->call($this, 'comparator');
        $self = $this;
        $result = $self->getResultsStorage()->read($comparator);
        StrUtil::writeln('Результат вычислений равен = '.($result ? 'РАВНЫ' : 'НЕРАВНЫ'));
        $this->getController()->go($this, 'output', function($output) use ($self, $comparator, $result) {
            $self->getInputsStorage()->write(
                $output,
                $result
            );
        });
    }
}
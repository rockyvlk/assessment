<?php

declare(strict_types=1);

namespace Lib\Application\Query\Parameters;

use Symfony\Component\Validator\Constraints as Assert;

trait WithPagination
{
    #[
        Assert\Valid
    ]
    public ?Page $page = null;

    public function withPagination(Page $page): self
    {
        $this->page = $page;
        return clone $this;
    }
}

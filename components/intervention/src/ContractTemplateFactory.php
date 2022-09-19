<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace Pis0sion\Intervention;

use Hyperf\Context\Context;
use Hyperf\Utils\Collection;
use Pis0sion\Intervention\Contract\PageTemplateInterface;
use Pis0sion\Intervention\Exception\InvalidMIMETypeException;

/**
 * \Pis0sion\Intervention\ContractTemplateFactory.
 */
class ContractTemplateFactory
{
    /**
     * getPageTemplates.
     */
    public function getPageTemplates(): Collection|null
    {
        return Context::get('pageTemplates');
    }

    /**
     * setPageTemplates.
     * @return \Hyperf\Utils\Collection
     */
    public function setPageTemplates(Collection $pageTemplates)
    {
        Context::set('pageTemplates', $pageTemplates);
        return $pageTemplates;
    }

    /**
     * addPageTemplates.
     */
    public function addPageTemplates(int $page, PageTemplateInterface $pageTemplate): void
    {
        $pageTemplateEntity = $this->getPageTemplates() ?? $this->setPageTemplates(new Collection());
        $pageTemplateEntity->put($page, $pageTemplate);
    }

    /**
     * renderContractTemplate.
     */
    public function renderContractTemplate(): array
    {
        $handlerParallelFunc = $this->getPageTemplates()->map(fn (PageTemplateInterface $pageTemplate) => function () use ($pageTemplate) {
            $this->render2PageTemplate($pageTemplate);
            return $pageTemplate->save2Page();
        });

        return parallel($handlerParallelFunc::unwrap($handlerParallelFunc));
    }

    /**
     * render2PageTemplate.
     */
    protected function render2PageTemplate(PageTemplateInterface $pageTemplate): array
    {
        return array_map($this->multiRenderPerPageTemplate($pageTemplate), $pageTemplate->getRenderParameters());
    }

    /**
     * multiRender2PageTemplate.
     * @return \Closure
     */
    protected function multiRenderPerPageTemplate(PageTemplateInterface $pageTemplate)
    {
        return fn ($renderParameter) => match ($renderParameter['type']) {
            MimeType::TEXT_TYPE => $pageTemplate->inputText2PageTemplate($renderParameter),
            MimeType::IMAGE_TYPE => $pageTemplate->insertImageResource2PageTemplate($renderParameter),
            default => throw new InvalidMIMETypeException('无效的渲染类型'),
        };
    }
}

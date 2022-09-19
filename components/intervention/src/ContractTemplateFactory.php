<?php

namespace Pis0sion\Intervention;

use Hyperf\Context\Context;
use Hyperf\Utils\Collection;
use Pis0sion\Intervention\Contract\PageTemplateInterface;
use Pis0sion\Intervention\Exception\InvalidMIMETypeException;

/**
 * \Pis0sion\Intervention\ContractTemplateFactory
 */
class ContractTemplateFactory
{

    /**
     * getPageTemplates
     * @return \Hyperf\Utils\Collection|null
     */
    public function getPageTemplates(): Collection|null
    {
        return Context::get("pageTemplates");
    }

    /**
     * setPageTemplates
     * @param \Hyperf\Utils\Collection $pageTemplates
     * @return \Hyperf\Utils\Collection
     */
    public function setPageTemplates(Collection $pageTemplates)
    {
        Context::set("pageTemplates", $pageTemplates);
        return $pageTemplates;
    }

    /**
     * addPageTemplates
     * @param int $page
     * @param \Pis0sion\Intervention\Contract\PageTemplateInterface $pageTemplate
     */
    public function addPageTemplates(int $page, PageTemplateInterface $pageTemplate): void
    {
        $pageTemplateEntity = $this->getPageTemplates() ?? $this->setPageTemplates(new Collection());
        $pageTemplateEntity->put($page, $pageTemplate);
    }

    /**
     * renderContractTemplate
     * @return array
     */
    public function renderContractTemplate(): array
    {
        $handlerParallelFunc = $this->getPageTemplates()->map(fn(PageTemplateInterface $pageTemplate) => function () use ($pageTemplate) {
            $this->render2PageTemplate($pageTemplate);
            return $pageTemplate->save2Page();
        });

        return parallel($handlerParallelFunc::unwrap($handlerParallelFunc));
    }

    /**
     * render2PageTemplate
     * @param \Pis0sion\Intervention\Contract\PageTemplateInterface $pageTemplate
     * @return array
     */
    protected function render2PageTemplate(PageTemplateInterface $pageTemplate): array
    {
        return array_map($this->multiRenderPerPageTemplate($pageTemplate), $pageTemplate->getRenderParameters());
    }

    /**
     * multiRender2PageTemplate
     * @return \Closure
     */
    protected function multiRenderPerPageTemplate(PageTemplateInterface $pageTemplate)
    {
        return fn($renderParameter) => match ($renderParameter["type"]) {
            MimeType::TEXT_TYPE => $pageTemplate->inputText2PageTemplate($renderParameter),
            MimeType::IMAGE_TYPE => $pageTemplate->insertImageResource2PageTemplate($renderParameter),
            default => throw new InvalidMIMETypeException("无效的渲染类型"),
        };
    }
}
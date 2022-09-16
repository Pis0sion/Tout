<?php

namespace Pis0sion\Intervention;

use Hyperf\Utils\Collection;
use Pis0sion\Intervention\Contract\PageTemplateInterface;
use Pis0sion\Intervention\Exception\InvalidMIMETypeException;

/**
 * \Pis0sion\Intervention\ContractTemplateFactory
 */
class ContractTemplateFactory
{
    /**
     * @var \Hyperf\Utils\Collection $pageTemplates
     */
    protected Collection $pageTemplates;

    /**
     * @return \Hyperf\Utils\Collection
     */
    public function getPageTemplates(): Collection
    {
        return $this->pageTemplates;
    }

    /**
     * setPageTemplates
     * @param int $page
     * @param \Pis0sion\Intervention\Contract\PageTemplateInterface $pageTemplate
     */
    public function addPageTemplates(int $page, PageTemplateInterface $pageTemplate): void
    {
        $this->pageTemplates->put($page, $pageTemplate);
    }

    /**
     * renderContractTemplate
     */
    public function renderContractTemplate()
    {
        $callback = [];

        $this->pageTemplates->each(function (PageTemplateInterface $pageTemplate, int $page) use (&$callback) {
            $this->render2PageTemplate($pageTemplate);
            $callback[$page] = fn() => $pageTemplate->save2Page();
        });

        return parallel($callback);
    }

    /**
     * render2PageTemplate
     * @param \Pis0sion\Intervention\Contract\PageTemplateInterface $pageTemplate
     * @return array
     */
    protected function render2PageTemplate(PageTemplateInterface $pageTemplate)
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
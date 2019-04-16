<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: jeroen
 * Date: 11-4-19
 * Time: 21:04
 */

namespace Elgentos\PrismicIO\Block;

use Elgentos\PrismicIO\Exception\DocumentNotFoundException;
use Elgentos\PrismicIO\Exception\ContextNotFoundException;
use Elgentos\PrismicIO\ViewModel\DocumentResolver;
use Elgentos\PrismicIO\ViewModel\LinkResolver;
use Magento\Framework\View\Element\Template;

abstract class AbstractTemplate extends Template implements BlockInterface
{
    const CONTEXT_DELIMITER = '.';

    /** @var LinkResolver */
    private $linkResolver;
    /** @var DocumentResolver */
    private $documentResolver;

    public function __construct(
        Template\Context $context,
        DocumentResolver $documentResolver,
        LinkResolver $linkResolver,
        array $data = []
    ) {
        $this->linkResolver = $linkResolver;
        $this->documentResolver = $documentResolver;

        parent::__construct($context, $data);
    }

    public function getLinkResolver(): LinkResolver
    {
        return $this->linkResolver;
    }

    /**
     * @return DocumentResolver
     */
    public function getDocumentResolver(): DocumentResolver
    {
        return $this->documentResolver;
    }

    /**
     *
     * @return array|\stdClass|string
     * @throws ContextNotFoundException
     * @throws DocumentNotFoundException
     */
    public function getContext()
    {
        return $this->getDocumentResolver()
                ->getContext($this->getReference());
    }

    public function getReference(): string
    {
        return $this->_getData(BlockInterface::REFERENCE_KEY) ?: '*';
    }

    public function setReference(string $reference): void
    {
        $this->setData(BlockInterface::REFERENCE_KEY, $reference);
    }

}
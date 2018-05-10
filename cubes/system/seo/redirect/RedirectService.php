<?php

namespace cubes\system\seo\redirect;

use cubes\system\seo\redirect\repository\RedirectRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityService;

class RedirectService extends AbstractEntityService implements RedirectRepositoryInterface
{

    /**
     * @var RedirectRepositoryInterface
     */
    protected $repository;
    /**
     * @var Request
     */
    protected $request;

    /**
     * @param RedirectRepositoryInterface $repository
     * @param Request $request
     */
    public function __construct(RedirectRepositoryInterface $repository, Request $request)
    {
        parent::__construct($repository);
        $this->request = $request;
    }

    /**
     * @return null
     */
    public function getRedirectUrl()
    {
        $url = $this->request->getRequestUri();
        /** @var Redirect $item */
        if ($item = $this->findOne($this->createCondition(['url_from' => $url]))) {
            return $item->url_to;
        }
        return null;
    }

    /**
     * @param Redirect|AbstractEntity $item
     * @param array $oldData
     */
    public function save(AbstractEntity $item, array $oldData = [])
    {
        $this->preventDuplicates($item);
        parent::save($item, $oldData);
    }

    /**
     * @param Redirect $item
     */
    protected function preventDuplicates(Redirect $item)
    {
        /** @var Redirect $otherItem */
        $otherItem = $this->findOne($this->createCondition(['url_from' => $item->url_from]));
        if ($otherItem !== null && $otherItem->getId() !== $item->getId()) {
            $this->delete($otherItem->getId());
        }
    }
}

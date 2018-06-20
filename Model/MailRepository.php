<?php
/**
 *
 * @package     magento2
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */

namespace Codilar\MailTracker\Model;


use Codilar\MailTracker\Api\MailRepositoryInterface;
use Codilar\MailTracker\Model\Mail as Model;
use Codilar\MailTracker\Model\MailFactory as ModelFactory;
use Codilar\MailTracker\Model\ResourceModel\Mail as ResourceModel;
use Codilar\MailTracker\Model\ResourceModel\Mail\Collection;
use Codilar\MailTracker\Model\ResourceModel\Mail\CollectionFactory;

use Magento\Framework\Exception\LocalizedException;use Magento\Framework\Exception\NoSuchEntityException;class MailRepository implements MailRepositoryInterface
{
    /**
     * @var ModelFactory
     */
    private $modelFactory;
    /**
     * @var ResourceModel
     */
    private $resourceModel;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * MeasurementRepository constructor.
     * @param ModelFactory $modelFactory
     * @param ResourceModel $resourceModel
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        ModelFactory $modelFactory,
        ResourceModel $resourceModel,
        CollectionFactory $collectionFactory
    )
    {
        $this->modelFactory = $modelFactory;
        $this->resourceModel = $resourceModel;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param string $value
     * @param string $field
     * @throws NoSuchEntityException
     * @return Model
     */
    public function load($value, $field = self::ID_FIELD_NAME)
    {
        $model = $this->create();
        $this->resourceModel->load($model, $value, $field);
        if (!$model->getId()) {
            throw new NoSuchEntityException(__("No such entity with $field = $value"));
        }
        return $model;
    }

    /**
     * @param Model $model
     * @throws LocalizedException
     * @return Model
     */
    public function save(Model $model)
    {
        $this->resourceModel->save($model);
        return $model;
    }

    /**
     * @return Collection
     */
    public function getCollection()
    {
        return $this->collectionFactory->create();
    }

    /**
     * @return Model
     */
    public function create()
    {
        return $this->modelFactory->create();
    }

    /**
     * @param Model $model
     * @throws LocalizedException
     * @return $this
     */
    public function delete(Model $model)
    {
        try {
            $this->resourceModel->delete($model);
            return $this;
        } catch (\Exception $exception) {
            throw new LocalizedException(__($exception->getMessage()));
        }
    }
}
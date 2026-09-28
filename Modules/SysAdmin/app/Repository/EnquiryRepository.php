<?php

namespace Modules\SysAdmin\Repository;

use Modules\SysAdmin\Core\Eloquent\Repository as BaseRepository;
use Modules\SysAdmin\Core\Eloquent\RequestCriteria;
use Modules\SysAdmin\Interfaces\EnquiryInterface;
use Modules\SysAdmin\Models\Enquiry;
use Modules\SysAdmin\Services\EnquiryWorkflowService;

/**
 * Class EnquiryRepositoryEloquent.
 */
class EnquiryRepository extends BaseRepository implements EnquiryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Enquiry::class;
    }

    public function getStatuses()
    {
        return Enquiry::$statuses;
    }

    public function saveOrUpdate($data, $id = 0)
    {
        $existing = $id !== 0 ? $this->find($id) : null;
        $oldStatus = $existing?->status;
        $status = (int) ($data['status'] ?? $existing?->status ?? Enquiry::STATUS_NEW);
        $data['status'] = $status;
        $data['priority'] = $data['priority'] ?? $existing?->priority ?? 'normal';
        $data['closed_at'] = Enquiry::isClosedStatus($status) ? ($existing?->closed_at ?? now()) : null;

        if ($id !== 0) {
            $enquiry = parent::update($data, $id);
        } else {
            $enquiry = parent::create($data);
        }

        $workflow = app(EnquiryWorkflowService::class);
        if (! $existing) {
            $workflow->activity($enquiry, 'created', 'Enquiry created from '.str($enquiry->enquiry_type ?: 'admin')->headline().'.');
        } elseif ((int) $oldStatus !== $status) {
            $workflow->activity(
                $enquiry,
                'status_change',
                'Status changed from '.(Enquiry::$statuses[(int) $oldStatus] ?? $oldStatus).' to '.(Enquiry::$statuses[$status] ?? $status).'.',
                ['from' => (int) $oldStatus, 'to' => $status],
            );
        }

        return $enquiry;
    }

    /**
     * Optional: common filters
     */
    public function getByCategory(int $categoryId)
    {
        return $this->model->where('category_id', $categoryId)->latest()->get();
    }

    public function getByProduct(int $productId)
    {
        return $this->model->where('product_id', $productId)->latest()->get();
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}

<?php
namespace Christiaan\ZohoCRMClient\Request;

use Christiaan\ZohoCRMClient\Response\MutationResult;

/**
 * InsertRecords API Call
 *
 * @see https://www.zoho.com/crm/help/api/updaterecords.html
 */
class UpdateRecords extends AbstractRequest
{
    /** @var array */
    private $records = array();

    protected function configureRequest()
    {
        $this->request
            ->setMethod('updateRecords');
    }

    /**
     * @param string $id
     * @return GetRecordById
     */
    public function id($id)
    {
        $this->request->setParam('id', $id);

        return $this;
    }

    /**
     * @param array $record Record as a simple associative array
     * @return UpdateRecords
     */
    public function addRecord(array $record)
    {
        $this->records[] = $record;
        return $this;
    }

    /**
     * @return array
     */
    public function getRecords()
    {
        return $this->records;
    }

    /**
     * @param array $records array containing records otherwise added by addRecord()
     * @return UpdateRecords
     */
    public function setRecords(array $records)
    {
        $this->records = $records;
        return $this;
    }

    /**
     * @return UpdateRecords
     */
    public function triggerWorkflow()
    {
        $this->request->setParam('wfTrigger', 'true');
        return $this;
    }

    /**
     * @return UpdateRecords
     */
    public function onDuplicateUpdate()
    {
        $this->request->setParam('duplicateCheck', 2);
        return $this;
    }

    /**
     * @return UpdateRecords
     */
    public function onDuplicateError()
    {
        $this->request->setParam('duplicateCheck', 1);
        return $this;
    }

    /**
     * @return UpdateRecords
     */
    public function requireApproval()
    {
        $this->request->setParam('isApproval', 'true');
        return $this;
    }

    /**
     * @return MutationResult[]
     */
    public function request()
    {
        if (count($this->records) > 1) {
            $this->request->setParam('id', null);
			$this->request->setParam('version', 4);
        }

        return $this->request
            ->setParam('xmlData', $this->records)
            ->request();
    }
}

<?php /** @noinspection PhpUnused */
/** @noinspection PhpUnused */
/** @noinspection PhpUnused */
/** @noinspection PhpUnused */
/** @noinspection PhpUnused */
/** @noinspection PhpUnused */
/** @noinspection PhpUnused */
/** @noinspection PhpUnused */
/** @noinspection PhpUnused */

/** @noinspection PhpUnused */

namespace App\Model;

class Task
{
    private $id_task;
    private String $title;
    private String $created;
    private String $updated;
    private String $status;

    /**
     * @return mixed
     */
    public function getIdTask()
    {
        return $this->id_task;
    }

    /**
     * @param mixed $id_task
     */
    public function setIdTask($id_task)
    {
        $this->id_task = $id_task;
    }

    /**
     * @return String
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param String $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return String
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param String $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return String
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param String $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return String
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param String $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}
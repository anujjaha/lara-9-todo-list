<?php 

namespace App\Repositories\Todo;

/**
 * Class EloquentTodoRepository
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\Todo\Todo;
use App\Repositories\DbRepository;
use App\Exceptions\GeneralException;

class EloquentTodoRepository extends DbRepository
{
    /**
     * Todo Model
     *
     * @var Object
     */
    public $model;
    
    /**
     * Construct
     *
     */
    public function __construct()
    {
        $this->model = new Todo;
    }

    /**
     * Create Todo
     *
     * @param array $input
     * @return mixed
     */
    public function create($input)
    {
        $input = $this->prepareInputData($input, true);
        $model = $this->model->create($input);

        return $model ?? false;
    }
    
    /**
     * Destroy Todo
     *
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        $model = $this->model->find($id);

        return $model ? $model->delete() : false;
    }

    /**
     * Get All
     *
     * @param string $orderBy
     * @param string $sort
     * @return Todo[]
     */
    public function getAll(string $orderBy = 'id', string $sort = 'asc')
    {
        return $this->model->orderBy($orderBy, $sort)->get();
    }

    /**
     * Get by Id
     *
     * @param int $id
     * @return mixed
     */
    public function getById(?int $id = null): ?Todo
    {
        return $this->model->find($id) ?? false;
    }
    
    /**
     * Prepare Input Data
     *
     * @param array $input
     * @param bool $isCreate
     * @return array
     */
    public function prepareInputData(array $input = [], bool $isCreate = false): array
    {
        if($isCreate)
        {
            $input = array_merge($input, ['user_id' => auth()->user()->id]);
        }

        return $input;
    }   
}

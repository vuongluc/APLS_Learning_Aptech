<?php
    namespace App\Domain\Classes;
    use App\Domain\CLasses\ClassDTO;
    use App\Model\Classes;
    use Illuminate\Support\Facades\DB;

    class ClassBusiness{
        public function findAll(){
            return Classes::all();
        }

        public function findById($id){
            $entity = Classes::find($id);  
            return $this->dtoFromEntity($entity);
        }

        public function update(ClassDTO $dto){
            $classes = Classes::find($dto->classId);
            $classes->ClassId = $dto->classId;
            $classes->TeachingHour = $dto->teachingHour;
            $classes->ModuleId = $dto->moduleId;
            $classes->StatusId = $dto->statusId;
            $classes->TeacherId = $dto->teacherId;
            $classes->TypeId = $dto->typeId;
            $classes->save();
        }

        public function store(ClassDTO $dto){
            $newClass = $this->entityFromDto($dto);
            $newClass->save();
        }


        public function dtoFromEntity(Classes $entity)
        {
            $dto = new ClassDTO();

            $dto->classId = $entity->ClassId;
            $dto->teachingHour = $entity->TeachingHour;
            $dto->moduleId = $entity->ModuleId;
            $dto->statusId = $entity->StatusId;
            $dto->teacherId = $entity->TeacherId;
            $dto->typeId = $entity->TypeId;
            return $dto;
        }

        public function entityFromDto(ClassDTO $dto)
        {
            $entity = new Classes();

            $entity->ClassId = $dto->classId;
            $entity->TeachingHour = $dto->teachingHour;
            $entity->ModuleId = $dto->moduleId;
            $entity->StatusId= $dto->statusId;
            $entity->TeacherId = $dto->teacherId;
            $entity->TypeId = $dto->typeId;
            return $entity;
        }
    }


?>
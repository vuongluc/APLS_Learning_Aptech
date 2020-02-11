<?php
    namespace App\Domain\ClassType;
    use App\Domain\Classtype\ClassTypeDTO;
    use App\Model\ClassType;

class ClassTypeBusiness{

        public function findAll(){
            return ClassType::all();
        }

        public function store(ClassTypeDTO $dto){
            $newClasstype = $this->entityFromDto($dto);
            $newClasstype->save();
        }

        public function findById($id){
           $entity = ClassType::find($id);  
           return $this->dtoFromEntity($entity);
        }

        public function update(ClassTypeDTO $dto){
            $classtype = ClassType::find($dto->typeId);
            $classtype->TypeId = $dto->typeId;
            $classtype->TeachingTime = $dto->teachingTime;
            $classtype->save();
        }

        public function destroy($id){
            $classtype = ClassType::find($id);
            $classtype->delete();            
        }



        public function dtoFromEntity(ClassType $entity){
            $dto = new ClassTypeDTO();

            $dto->typeId = $entity->TypeId;
            $dto->teachingTime = $entity->TeachingTime;     
            return $dto;
        }

        public function entityFromDto(ClassTypeDTO $dto){
            $entity = new ClassType();

            $entity->TypeId = $dto->typeId;
            $entity->TeachingTime = $dto->teachingTime;  
            return $entity;
        }
    }
?>
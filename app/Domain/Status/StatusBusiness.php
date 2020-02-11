<?php
    namespace App\Domain\Status;
    use App\Domain\Status\StatusDTO;
    use App\Model\Status;

class StatusBusiness{
        public function findAll(){
            return Status::all();
        }

        public function store(StatusDTO $dto){
            $status = $this->entityFromDto($dto);
            $status->save();
        }

        public function findById($id){
            $entity = Status::find($id);  
            return $this->dtoFromEntity($entity);
        }

        public function update(StatusDTO $dto){
            $status = Status::find($dto->statusid);
            $status->StatusId = $dto->statusid;
            $status->Description = $dto->description;  
            $status->StatusName = $dto->statusname;
            $status->save();
        }

        public function destroy($id){
            $status = Status::find($id);
            $status->delete();            
        }


        public function dtoFromEntity(Status $entity){
            $dto = new StatusDTO();

            $dto->statusid = $entity->StatusId;
            $dto->description = $entity->Description;  
            $dto->statusname = $entity->StatusName;   
            return $dto;
        }

        public function entityFromDto(StatusDTO $dto){
            $entity = new Status();

            $entity->StatusId = $dto->statusid;
            $entity->Description = $dto->description;  
            $entity->StatusName = $dto->statusname;
            return $entity;
        }
    }
?>
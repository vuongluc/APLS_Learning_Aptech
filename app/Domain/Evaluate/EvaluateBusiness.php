<?php
    namespace App\Domain\Evaluate;
    use App\Domain\Evaluate\EvaluateDTO;
    use App\Model\Evaluate;

    class EvaluateBusiness{
        
        public function findAll(){
            return Evaluate::all();
        }

        public function store(EvaluateDTO $dto)
        {
            $evalate = $this->entityFromDto($dto);
            $evalate->save();
        }

        public function update(EvaluateDTO $dto){
            $evaluate = Evaluate::where('StudentId', '=', $dto->studentid)->where('ClassId', '=', $dto->classid)->first();
            $evaluate->ClassId = $dto->classid;
            $evaluate->StudentId = $dto->studentid;
            $evaluate->Understand = $dto->understand;
            $evaluate->Punctuality = $dto->punctuality;
            $evaluate->Support = $dto->support;
            $evaluate->Teaching = $dto->teaching; 
            $evaluate->save();
        }


        public function dtoFromEntity(Evaluate $entity){
            $dto = new EvaluateDTO();

            $dto->classid = $entity->ClassId;
            $dto->studentid = $entity->StudentId;             
            $dto->understand = $entity->Understand;
            $dto->punctuality = $entity->Punctuality;             
            $dto->support = $entity->Support;
            $dto->teaching = $entity->Teaching;      
            return $dto;
        }

        public function entityFromDto(EvaluateDTO $dto){
            $entity = new Evaluate();

            $entity->ClassId = $dto->classid;
            $entity->StudentId = $dto->studentid;
            $entity->Understand = $dto->understand;
            $entity->Punctuality = $dto->punctuality;
            $entity->Support = $dto->support;
            $entity->Teaching = $dto->teaching;  
            return $entity;
        }
    }

?>
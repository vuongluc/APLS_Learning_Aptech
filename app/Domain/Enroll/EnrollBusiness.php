<?php
    namespace App\Domain\Enroll;
    use App\Domain\Enroll\EnrollDTO;
    use App\Model\Enroll;

    class EnrollBusiness{


        public function findAll(){
            return Enroll::all();
        }

        public function store(EnrollDTO $dto)
        {
            $enroll = $this->entityFromDto($dto);
            $enroll->save();
        }

        public function update(EnrollDTO $dto){
            $enroll = Enroll::where('StudentId', '=', $dto->studentid)->where('ClassId', '=', $dto->classid)->first();
            $enroll->ClassId = $dto->classid;
            $enroll->StudentId = $dto->studentid;
            $enroll->Hw1Grade = $dto->hw1grade;
            $enroll->Hw2Grade = $dto->hw2grade;
            $enroll->Hw3Grade = $dto->hw3grade;
            $enroll->Hw4Grade = $dto->hw4grade; 
            $enroll->Hw5Grade = $dto->hw5grade;
            $enroll->ExamGrade = $dto->examgrade;
            $enroll->Passed = $dto->passed; 
            $enroll->save();
        }

        public function dtoFromEntity(Enroll $entity){
            $dto = new EnrollDTO();

            $dto->classid = $entity->ClassId;
            $dto->studentid = $entity->StudentId;             
            $dto->passed = $entity->Passed;
            $dto->hw1grade = $entity->Hw1Grade;             
            $dto->hw2grade = $entity->Hw2Grade;
            $dto->hw3grade = $entity->Hw3Grade; 
            $dto->hw4grade = $entity->Hw4Grade;             
            $dto->hw5grade = $entity->Hw5Grade;
            $dto->examgrade = $entity->ExamGrade;      
            return $dto;
        }

        public function entityFromDto(EnrollDTO $dto){
            $entity = new Enroll();

            $entity->ClassId = $dto->classid;
            $entity->StudentId = $dto->studentid;
            $entity->Passed = $dto->passed;
            $entity->Hw1Grade = $dto->hw1grade;
            $entity->Hw2Grade = $dto->hw2grade;
            $entity->Hw3Grade = $dto->hw3grade;
            $entity->Hw4Grade = $dto->hw4grade;  
            $entity->Hw5Grade = $dto->hw5grade;
            $entity->ExamGrade = $dto->examgrade;  
            return $entity;
        }
    }
    
?>
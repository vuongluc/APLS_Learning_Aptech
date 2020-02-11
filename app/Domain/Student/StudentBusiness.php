<?php
namespace App\Domain\Student;

use App\Domain\Student\StudentDTO;
use App\Model\Student;

class StudentBusiness
{
    public function findAll()
    {
        return Student::all();
    }

    public function store(StudentDTO $dto)
    {
        $student = $this->entityFromDto($dto);
        $student->save();
    }

    public function findById($id)
    {
        $entity = Student::where('StudentId', $id)->first();
        return $this->dtoFromEntity($entity);
    }
    

    public function update(StudentDTO $dto){
        $students = Student::find($dto->studentId);
        $students->StudentId = $dto->studentId;
        $students->FirstName = $dto->firstName;
        $students->LastName = $dto->lastName;
        $students->Contact = $dto->contact;
        $students->BirthDate = $dto->birthDate;
        $students->StatusId = $dto->statusId;
        $students->save();
    }

    public function destroy($id){
        $student = Student::find($id);
        $student->delete();            
    }


    public function dtoFromEntity(Student $entity)
    {
        $dto = new StudentDTO();

        $dto->studentId = $entity->StudentId;
        $dto->firstName = $entity->FirstName;
        $dto->lastName = $entity->LastName;
        $dto->contact = $entity->Contact;
        $dto->birthDate = explode(' ',$entity->BirthDate)[0];
        $dto->statusId = $entity->StatusId;
        return $dto;
    }

    public function entityFromDto(StudentDTO $dto)
    {
        $entity = new Student();

        $entity->StudentId = $dto->studentId;
        $entity->FirstName = $dto->firstName;
        $entity->LastName = $dto->lastName;
        $entity->Contact= $dto->contact;
        $entity->BirthDate = $dto->birthDate;
        $entity->StatusId = $dto->statusId;
        return $entity;
    }

    //API
    public function create(StudentDTO $dto){
        $newStudent = $this->entityFromDto($dto);
        $newStudent->save();
        return $this->dtoFromEntity($newStudent); 
    }

}

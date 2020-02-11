<?php
namespace App\Domain\Teacher;

use App\Domain\Teacher\TeacherDTO;
use App\Model\Teacher;

class TeacherBusiness
{
    public function findAll()
    {
        return Teacher::all();
    }
    public function findById($id)
    {
        $entity = Teacher::where('TeacherId', $id)->first();
        return $this->dtoFromEntity($entity);
    }
    public function store(TeacherDTO $dto)
    {
        $teacher = $this->entityFromDto($dto);
        $teacher->save();
    }
    public function update(TeacherDTO $dto){
        $teachers = Teacher::find($dto->teacherId);
        $teachers->TeacherId = $dto->teacherId;
        $teachers->FirstName = $dto->firstName;
        $teachers->LastName = $dto->lastName;
        $teachers->Contact = $dto->contact;
        $teachers->BirthDate = $dto->birthDate;
        $teachers->StatusId = $dto->statusId;
        $teachers->save();
    }


    public function dtoFromEntity(Teacher $entity)
    {
        $dto = new TeacherDTO();

        $dto->teacherId = $entity->TeacherId;
        $dto->firstName = $entity->FirstName;
        $dto->lastName = $entity->LastName;
        $dto->contact = $entity->Contact;
        $dto->birthDate = explode(' ',$entity->BirthDate)[0];
        $dto->statusId = $entity->StatusId;
        return $dto;
    }

    public function entityFromDto(TeacherDTO $dto)
    {
        $entity = new Teacher();

        $entity->TeacherId = $dto->teacherId;
        $entity->FirstName = $dto->firstName;
        $entity->LastName = $dto->lastName;
        $entity->Contact= $dto->contact;
        $entity->BirthDate = $dto->birthDate;
        $entity->StatusId = $dto->statusId;
        return $entity;
    }
}
?>
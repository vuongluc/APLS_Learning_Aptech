<?php
namespace App\Domain\Student;

use App\Domain\Student\StudentDTO;
use App\Model\Student;
use GuzzleHttp\Client;

class ApiStudentBusiness
{

    const BASE_URI = 'http://localhost:52593/api/';

    public function findAll()
    {
        $studentList = [];
        $client = new Client([
            'base_uri' => self::BASE_URI
        ]);

        $response = $client->get('students');
        $jArray = json_decode($response->getBody(), true); //true to have associative array
        foreach ($jArray as $jStudent) {
            $student = new StudentDTO();
            $student->studentId = $jStudent['StudentId'];
            $student->firstName = $jStudent['FirstName'];
            $student->lastName = $jStudent['LastName'];
            $student->contact = $jStudent['Contact'];
            $student->birthDate = $jStudent['BirthDate'];
            $student->statusId = $jStudent['StatusId'];
            $studentList[] = $student;
        }
        return $studentList;
        // return Student::all();
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


    
}

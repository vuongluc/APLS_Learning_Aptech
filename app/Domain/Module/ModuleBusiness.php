<?php
namespace App\Domain\Module;

use App\Domain\Module\ModuleDTO;
use App\Model\Module;

class ModuleBusiness
{

    public function findAll()
    {
        return Module::all();
    }

    public function store(ModuleDTO $dto)
    {
        $module = $this->entityFromDto($dto);
        $module->save();
    }

    public function findById($id)
    {
        $entity = Module::where('ModuleId', $id)->first();
        return $this->dtoFromEntity($entity);
    }

    public function destroy($id){
        $module = Module::find($id);
        $module->delete();            
    }


    public function update(ModuleDTO $dto){
        $module = Module::find($dto->moduleId);
        $module->ModuleId = $dto->moduleId;
        $module->Duration = $dto->duration;
        $module->ModuleName = $dto->moduleName;
        $module->Homework = $dto->homeWork;
        $module->save();
    }

    
    public function dtoFromEntity(Module $entity)
    {
        $dto = new ModuleDTO();

        $dto->moduleId = $entity->ModuleId;
        $dto->duration = $entity->Duration;
        $dto->moduleName = $entity->ModuleName;
        $dto->homeWork = $entity->Homework;
        return $dto;
    }

    public function entityFromDto(ModuleDTO $dto)
    {
        $entity = new Module();

        $entity->ModuleId = $dto->moduleId;
        $entity->Duration = $dto->duration;
        $entity->ModuleName = $dto->moduleName;
        $entity->Homework = $dto->homeWork;
        return $entity;
    }

}

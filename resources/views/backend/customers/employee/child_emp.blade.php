@foreach($child_employees as $parent)
    <option value="{{ $parent->id }}" {{ (old('placement_id'))? ($parent->id == old('placement_id')? 'selected': '') : '' }}>({{ $parent->id }}) - {{ getEmpInfo($parent->id)->user->name." ".getEmpInfo($parent->id)->user->last_name[0] }}</option>
        @if($parent->child_employees->isNotEmpty())
            @include('backend.customers.employee.child_emp', [
                'child_employees' => $parent->child_employees
            ])
        @endif
@endforeach

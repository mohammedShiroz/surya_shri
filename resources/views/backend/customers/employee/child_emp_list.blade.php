@foreach($child_employees as $parent)
    @if($parent->child_employees->isNotEmpty())
            @include('backend.customers.employee.child_emp_list', [
                'child_employees' => $parent->child_employees
            ])
    @endif
@endforeach

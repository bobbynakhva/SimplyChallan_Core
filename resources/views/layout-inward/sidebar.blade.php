<div class="side__sticky">
   <ul class="common__sidebar__wrapper">
      
      <li class="common__sideitems">
         <a href="{{ route('inward.challan.create') }}" class="{{ request()->routeIs('inward.challan.create') ? 'active' : '' }}">
           New Inward Challan
         </a>
      </li>
       <li class="common__sideitems">
         <a href="{{ route('inward.dashboard') }}" class="{{ request()->routeIs('inward.dashboard') ? 'active' : '' }}">
            Inward Challan
         </a>
      </li>
      <li class="common__sideitems">
         <a href="{{ route('inward.challan.reports') }}" class="{{ request()->routeIs('inward.challan.reports') ? 'active' : '' }}">
            Reports
         </a>
      </li>
      <li class="common__sideitems">
         <a href="{{ route('inward.purposes.index') }}" class="{{ request()->routeIs('inward.purposes.index') ? 'active' : '' }}">
         New Purpose
         </a>
      </li>
  </ul>
</div>

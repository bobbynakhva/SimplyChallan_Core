@push('styles')
<style>
    /* Modern Light Sidebar matching Website Theme */
    .side__sticky {
        position: sticky;
        top: 100px !important;
        z-index: 50;
    }

    ul.common__sidebar__wrapper {
        background: #ffffff; /* Clean White Background */
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        min-height: calc(100vh - 120px);
        display: flex;
        flex-direction: column;
        gap: 8px;
        border: 1px solid #e2e8f0;
        margin-top: 20px;
    }

    .common__sideitems {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        color: #64748b; /* Slate 500 */
        text-decoration: none;
        font-family: 'Outfit', 'Inter', system-ui, -apple-system, sans-serif !important;
        font-weight: 500;
        font-size: 0.9rem;
        border-radius: 8px; /* Slightly tighter radius */
        transition: all 0.2s ease;
        letter-spacing: 0.01em;
        border: 1px solid transparent;
        text-transform: uppercase; /* Matching the screenshot's uppercase style */
        font-size: 0.85rem;
    }

    /* Hover State */
    .sidebar-link:hover {
        background-color: #f1f5f9;
        color: #0f172a;
        transform: translateX(4px);
    }

    /* Active State: Bold Black */
    .sidebar-link.active {
        background-color: #000000 !important; /* Pure Black Active */
        color: #ffffff !important;
        font-weight: 600;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2);
    }

    .sidebar-link i {
        font-size: 1.1rem;
        width: 24px;
        text-align: center;
        transition: transform 0.2s ease;
    }

    /* Icon Animation */
    .sidebar-link:hover i,
    .sidebar-link.active i {
        transform: scale(1.1);
    }
</style>
@endpush

<div class="side__sticky">
   <ul class="common__sidebar__wrapper">
      
      <!-- NEW INWARD CHALLAN -->
      <li class="common__sideitems">
         <a href="{{ route('inward.challan.create') }}" class="sidebar-link {{ request()->routeIs('inward.challan.create') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-plus"></i>
            <span>New Inward Challan</span>
         </a>
      </li>

      <!-- INWARD CHALLAN DASHBOARD -->
      <li class="common__sideitems">
         <a href="{{ route('inward.dashboard') }}" class="sidebar-link {{ request()->routeIs('inward.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid"></i>
            <span>Inward Challan</span>
         </a>
      </li>

      <!-- REPORTS -->
      <li class="common__sideitems">
         <a href="{{ route('inward.challan.reports') }}" class="sidebar-link {{ request()->routeIs('inward.challan.reports') ? 'active' : '' }}">
            <i class="bi bi-graph-up-arrow"></i>
            <span>Reports</span>
         </a>
      </li>

      <!-- PURPOSE -->
      <li class="common__sideitems">
         <a href="{{ route('inward.purposes.index') }}" class="sidebar-link {{ request()->routeIs('inward.purposes.index') ? 'active' : '' }}">
            <i class="bi bi-tag"></i>
            <span>Manage Purpose</span>
         </a>
      </li>

   </ul>
</div>

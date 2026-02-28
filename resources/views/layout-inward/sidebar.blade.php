@push('styles')
<style>
    /* Modern Premium Sidebar - Titan Noir Theme */
    .side__sticky {
        position: sticky;
        top: 100px !important;
        z-index: 50;
    }

    ul.common__sidebar__wrapper {
        background: #ffffff;
        border-radius: 20px;
        padding: 24px 16px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        min-height: calc(100vh - 120px);
        display: flex;
        flex-direction: column;
        gap: 12px;
        border: 1px solid #f1f5f9;
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
        gap: 14px;
        padding: 14px 20px;
        color: #64748b;
        text-decoration: none;
        font-family: 'Inter', system-ui, -apple-system, sans-serif !important;
        font-weight: 600;
        font-size: 0.8rem;
        border-radius: 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    /* Hover State */
    .sidebar-link:hover {
        background: #f8fafc;
        color: #0f172a;
        transform: translateX(8px);
    }

    /* Active State: Vibrant Indigo Gradient */
    .sidebar-link.active {
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.2);
    }

    .sidebar-link i {
        font-size: 1.25rem;
        transition: transform 0.3s ease;
    }

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

      <!-- BACKUP & RESTORE -->
      <li class="common__sideitems">
         <a href="{{ route('backup.index') }}" class="sidebar-link {{ request()->routeIs('backup.index') ? 'active' : '' }}">
            <i class="bi bi-shield-lock"></i>
            <span>Backup & Restore</span>
         </a>
      </li>

   </ul>
</div>

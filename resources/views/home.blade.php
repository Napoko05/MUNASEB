 @include('layouts.head') 
 <!-- [ Sidebar Menu ] start -->

 @include('layouts.sidebar') 

     <!-- [ Main Content ] start -->
    <div class="pc-container">
      <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
          <div class="page-block card mb-0">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-md-12">
                  <div class="page-header-title border-bottom pb-2 mb-2">
                    <h4 class="mb-0">Dashboard</h4>
                  </div>
                </div>
                <div class="col-md-12">
                  <ul class="breadcrumb">
                    <li class="breadcrumb-item"
                      ><a href="../dashboard/index.html"><i class="ph ph-house"></i></a
                    ></li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                  </ul>
                  <div class="row mt-4">
                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-body">
                          <h5 class="mb-3">Agenda</h5>
                          <div id="calendar" style="width: 100%; min-height: 500px;"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- [ breadcrumb ] end -->
         
        </div>
        <!-- [ Main Content ] end -->
      </div>
    </div>
@include('layouts.footer') 

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'fr',
      height: '100%',
      expandRows: true,
      windowResize: true,
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      events: [
        { title: 'Réunion', start: '2025-08-20' },
        { title: 'Livraison projet', start: '2025-08-25' }
      ]
    });
    calendar.render();
  });
</script>




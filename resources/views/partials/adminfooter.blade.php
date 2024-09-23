<div class="text-center pt-3 text-light">
    <p>Copyright © 2036 Your Company. All rights reserved.</p>
</div>
<script src="/js/modal.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>
<script>
    // datatable
    new DataTable('#example', {
    scrollX: true
    });
    
    // event will be executed when the toggle-button is clicked
    document.getElementById("button-toggle").addEventListener("click", () => {

        // when the button-toggle is clicked, it will add/remove the active-sidebar class
        document.getElementById("sidebar").classList.toggle("active-sidebar");

        // when the button-toggle is clicked, it will add/remove the active-main-content class
        document.getElementById("main-content").classList.toggle("active-main-content");
    });

    // fungsi show more
    $(document).ready(function() {
      $('.show-more-container').click(function() {
        var $this = $(this);
        $('#collapseExample').collapse('toggle');
        if ($this.find('.hr-text').attr('data-content') === 'Show More') {
          $this.find('.hr-text').attr('data-content', 'Show Less');
        } else {
          $this.find('.hr-text').attr('data-content', 'Show More');
        }
      });
    });
    const ctx = document.getElementById("myChart");

    // chart
    new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["January", "Februay", "March", "April", "May", "June"],
        datasets: [{
          label: "Monthly Revenue",
          //   cokot ti database berdasarkan bulan
          data: [2400000, 1440000, 3120000, 1500000, 705000, 0],
          borderWidth: 1,
        }, ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
      },
      
    });
</script>

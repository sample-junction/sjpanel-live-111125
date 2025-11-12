<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

    <!-- Bootstrap CSS -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
      integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
      crossorigin="anonymous"
    />

    <title>Hello, world!</title>
  </head>
  <body>
    <!-- Button trigger modal -->
    <button
      type="button"
      class="btn btn-primary"
      data-toggle="modal"
      data-target="#exampleModalCenter"
    >
      Launch demo modal
    </button>

    <!-- Modal -->
    <div
      class="modal fade"
      id="exampleModalCenter"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalCenterTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="alert alert-warning" role="alert">
                <i class="bi bi-info-circle"></i> You will get the <strong>100 Points</strong> for completing this
              survey
            </div>
            <div class="content">
              <p class="m-0">
                <strong
                  >We conduct monthly award ceremony to honor the
                  panelists</strong
                >
              </p>
              <p>
                Which day and time most preferable for you for SJ Panel monthly
                award ceremony
              </p>
            </div>
            <div class="mainform">
              <form action="">
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                      <select
                        class="form-control py-3 form-select"
                        id="exampleFormControlSelect1"
                        style="height: auto;"
                      >
                        <option value="" disabled selected>Select Weekdays</option>
                        <option value="1">Monday</option>
                        <option value="2">Tuesday</option>
                        <option value="3">Wednesday</option>
                        <option value="4">Thursday</option>
                        <option value="5">Friday</option>
                        <option value="6">Saturday</option>
                        <option value="7">Sunday</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <select
                        class="form-control py-3 form-select"
                        id="exampleFormControlSelect1"
                        style="height: auto;"
                        >
                        <option value="" disabled selected>Select Time</option>
                        <option value="00:00">12:00 AM</option>
                        <option value="00:30">12:30 AM</option>
                        <option value="01:00">1:00 AM</option>
                        <option value="01:30">1:30 AM</option>
                        <option value="02:00">2:00 AM</option>
                        <option value="02:30">2:30 AM</option>
                        <option value="03:00">3:00 AM</option>
                        <option value="03:30">3:30 AM</option>
                        <option value="04:00">4:00 AM</option>
                        <option value="04:30">4:30 AM</option>
                        <option value="05:00">5:00 AM</option>
                        <option value="05:30">5:30 AM</option>
                        <option value="06:00">6:00 AM</option>
                        <option value="06:30">6:30 AM</option>
                        <option value="07:00">7:00 AM</option>
                        <option value="07:30">7:30 AM</option>
                        <option value="08:00">8:00 AM</option>
                        <option value="08:30">8:30 AM</option>
                        <option value="09:00">9:00 AM</option>
                        <option value="09:30">9:30 AM</option>
                        <option value="10:00">10:00 AM</option>
                        <option value="10:30">10:30 AM</option>
                        <option value="11:00">11:00 AM</option>
                        <option value="11:30">11:30 AM</option>
                        <option value="12:00">12:00 PM</option>
                        <option value="12:30">12:30 PM</option>
                        <option value="13:00">1:00 PM</option>
                        <option value="13:30">1:30 PM</option>
                        <option value="14:00">2:00 PM</option>
                        <option value="14:30">2:30 PM</option>
                        <option value="15:00">3:00 PM</option>
                        <option value="15:30">3:30 PM</option>
                        <option value="16:00">4:00 PM</option>
                        <option value="16:30">4:30 PM</option>
                        <option value="17:00">5:00 PM</option>
                        <option value="17:30">5:30 PM</option>
                        <option value="18:00">6:00 PM</option>
                        <option value="18:30">6:30 PM</option>
                        <option value="19:00">7:00 PM</option>
                        <option value="19:30">7:30 PM</option>
                        <option value="20:00">8:00 PM</option>
                        <option value="20:30">8:30 PM</option>
                        <option value="21:00">9:00 PM</option>
                        <option value="21:30">9:30 PM</option>
                        <option value="22:00">10:00 PM</option>
                        <option value="22:30">10:30 PM</option>
                        <option value="23:00">11:00 PM</option>
                        <option value="23:30">11:30 PM</option>
                      </select>
                    </div>
                  </div>
                  <div class="text-center col-12">
                    <button type="button" class="btn btn-primary">
                      Save changes
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script
      src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
      integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
      integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
      integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
      crossorigin="anonymous"
    ></script>
  </body>
</html>

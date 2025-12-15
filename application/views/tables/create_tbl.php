<!--common header include -->
<?php $this->load->view('common_navbar');?>
 <link rel="stylesheet" href="<?= base_url(); ?>assets/css/jquery.signature.css">
   <link rel="stylesheet" href="<?= base_url(); ?>assets/css/jquery.betterdropdown.css">
 <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
 
<!-- common header include -->
<style>


.error-popup-msg-for-user ol li {
    margin-bottom: 10px;
    color: red;
}
.error-popup-msg-for-user p {
    color: red;
    margin-bottom: 10px;
}
.error-popup-msg-for-user ol {
    list-style: revert;
    padding: 0 15px;
    margin: 0;
}
.error-popup-msg-for-user {
    border: 1px solid #ff0f0f;
    background: #ff00000d;
    padding: 15px;
}

.pro_descrption{ display:none; } .delIcn{color: #ef8d91; margin-right: 7px;} 
      .addIcn{color: #709870; margin-right: 7px;} #putExtraVl{ width:100%;}
      .inrIcn{padding-top: 6px; text-align: right; height: calc(2.25rem + 2px); }
      .inrRp{padding-top: 6px;   height: calc(2.25rem + 2px); }
      .dropdown-box-wrapper, .result, .filter-box { height: calc(2.25rem + 2px); display: block;
    width: 100%;
    height: calc(2.25rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: transparent;
    background-clip: padding-box;
    border:0;
    border-bottom: 1px solid #ced4da;
    border-radius: .25rem;
    box-shadow: inset 0 0 0 transparent;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out; }
    .form-proforma .row {
	background: #f8faff;
	padding: 15px;
	margin: 0;
	}
	.form-proforma {
	background: #ffffff;
	padding: 0;
	}
	.form-footer-section .container {
	background: #f8faff;
	padding: 20px;
	}
	.form-footer-section {
	background: #ffffff;
	padding: 0;
	}
	.contact_details .container {
	background: #f8faff;
	padding: 15px;
	}
	.contact_details {
	padding: 0;
	background-color: #ffffff;
	}
  .linkscontainer{
width:70vw;
padding:20px;
padding-top:50px;
border-radius:10px;
box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
margin:20px auto;
margin-bottom:50px;

}


#btnSave {
  background-color: initial;
  background-image: linear-gradient(#8614f8 0, #760be0 100%);
  border-radius: 5px;
  border-style: none;
  box-shadow: rgba(245, 244, 247, .25) 0 1px 1px inset;
  color: #fff;
  cursor: pointer;
  display: inline-block;
  font-family: Inter, sans-serif;
  font-size: 16px;
  font-weight: 500;
  height: 40px;
  line-height: 20px;
  margin-left: -4px;
  outline: 0;
  text-align: center;
  transition: all .3s cubic-bezier(.05, .03, .35, 1);
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  vertical-align: bottom;
  width: 160px;
}

#btnSave:hover {
  opacity: .7;
}

@media screen and (max-width: 1000px) {
  #btnSave {
    font-size: 14px;
    height: 55px;
    line-height: 55px;
    width: 150px;
  }
}
@media screen and (max-width: 576px) {
.linkscontainer {
 width: 100vw;
}
}
</style>


<!-- modal Add lead status start-->
 <div class="modal fade" id="create_field" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Create Field </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="expanseForm" method="post" action="<?php echo base_url('add-expanse'); ?>">
              <div class="form-group">
                <label for="exampleInput"> Name <span class="text-danger">*</span>:</label>
                <input type="text" class="form-control" name="name" id="id" placeholder="Name">
              </div>
 
              <div class="form-group">
                <label for="">Types <span class="text-danger">*</span>:</label>
                <div class="input-group">
                  <select class="form-control" id="main_type" name="main_type">
                    <option value="" selected disabled>Select Type</option>
                    <option value="numeric">Numeric Data Types</option>
                    <option value="string">String (Character) Data Types</option>
                    <option value="date">Date and Time Data Types</option>
                    <option value="special">Other Special Types</option>
                  </select>
                </div>
              </div>

              <div class="form-group mt-3">
                <label for="">Field Data Type <span class="text-danger">*</span>:</label>
                <div class="input-group">
                  <select class="form-control" id="field_type" name="field_type">
                    <option value="" selected disabled>-- Select Field Type --</option>
                  </select>
                </div>
              </div>

              <script>
              // All MySQL data types categorized
              const dataTypes = {
                numeric: [
                  "TINYINT", "SMALLINT", "MEDIUMINT", "INT", "BIGINT",
                  "DECIMAL", "NUMERIC", "FLOAT", "DOUBLE", "REAL"
                ],
                string: [
                  "CHAR", "VARCHAR", "TINYTEXT", "TEXT", "MEDIUMTEXT", "LONGTEXT",
                  "TINYBLOB", "BLOB", "MEDIUMBLOB", "LONGBLOB",
                  "ENUM", "SET"
                ],
                date: [
                  "DATE", "DATETIME", "TIMESTAMP", "TIME", "YEAR"
                ],
                special: [
                  "BOOLEAN", "JSON"
                ]
              };

              // When main type changes
              document.getElementById("main_type").addEventListener("change", function() {
                const selected = this.value;
                const fieldSelect = document.getElementById("field_type");
                
                // Clear old options
                fieldSelect.innerHTML = '<option value="" disabled selected>-- Select Field Type --</option>';

                // Add new options based on selected category
                if (dataTypes[selected]) {
                  dataTypes[selected].forEach(type => {
                    const option = document.createElement("option");
                    option.value = type;
                    option.textContent = type;
                    fieldSelect.appendChild(option);
                  });
                }
              });
              </script>



              <div class="form-group">
                <label for="exampleInput"> Length <span class="text-danger">*</span>:</label>
                <input type="text" class="form-control" name="length" id="length" placeholder="Length">
              </div>

            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="saveChangesBtn">Submit</button>
          </div>
        </div>
      </div>
    </div>

    <!-- modal Add Lead status end-->






<div class="content-wrapper">

<?php if($this->session->userdata('account_type')=="Trial" && $countLead>=1000){ ?>
  <div class="content-header" style="background-color:rgba(240,240,246,0.8);">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-md-12 mb-3 mt-5 text-center">
              <i class="fas fa-exclamation-triangle" style="color: #f59393; font-size: 28px;"></i>
              </div>
            <div class="col-md-12 mb-3 text-center">
              You are now using trial account.<br>
			  <text>You are exceeded  your leads limit - 1,000'</text><br>
			  <text>You can add only  1,000 lead on trial account</text><br>
			  Please upgrade your plan to click bellow button.
            </div>
            <div class="col-md-12 mb-3 text-center">
              <a href="https://team365.io/pricing"><button class="btn btn-info">Buy Now</button></a>
            </div>
       
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>

<?php }else{ ?>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6 offset-sm-1">
          <h1 class="m-0 text-dark text-right" style="-webkit-text-fill-color: unset;">Create Table</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-5">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="<?php echo base_url()." home "; ?>">Home</a> </li>
             <li class="breadcrumb-item">
                 <a href="<?php echo base_url()."create_list "; ?>">Table</a>
            </li>
            <li class="breadcrumb-item active">Create table</li>
          </ol>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  
  
<div class="linkscontainer">
    <form class="form-horizontal"  id="tbl_data" method="post" enctype = "multipart/form-data">
        <div class="form-proforma">
            <div class="container">

                <!-- <div class="row">
                  <div class="col-lg-12">
                    <div class="refresh_button float-right" id ="create_fiels">  
                        <button class="btnstop" ><a href="#" style="color:#fff; padding: 0px;">Create fields</a></button>
                    </div>
                  </div>
                </div> -->

                    <div class="row">
                      <div class="col-lg-12">
                      <div class="form-group">
                          <label for="">Table Name <span class="text-danger">*</span>:</label>
                          <input type="text" class="form-control" id="table_name" name="table_name" placeholder="Enter Table Name">
                          <span id="table_name_error"></span>
                      </div>
                      </div>
                    </div>

                      <div id="fields">
                        <div>
                          <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                  <!-- <label for="">Column Name<span class="text-danger">*</span>:</label> -->
                                  <input type="hidden" class="form-control" name="fields[0][name]" placeholder="field Name" value="id" readonly>
                                </div>
                            </div>

                              <div class="col-lg-2">
                                <div class="form-group">
                                  <!-- <label for=""> Type <span class="text-danger">*</span>:</label>  -->
                                  <select class="form-control d-none" name="fields[0][type]">
                                    <option value="" selected disabled> Select Field Type </option>

                                    <!-- Numeric -->
                                    <option value="INT" selected>INT</option>
                                    <option value="TINYINT">TINYINT</option>
                                    <option value="SMALLINT">SMALLINT</option>
                                    <option value="MEDIUMINT">MEDIUMINT</option>
                                    <option value="BIGINT">BIGINT</option>
                                    <option value="DECIMAL">DECIMAL</option>
                                    <option value="FLOAT">FLOAT</option>
                                    <option value="DOUBLE">DOUBLE</option>

                                    <!-- String -->
                                    <option value="CHAR">CHAR</option>
                                    <option value="VARCHAR">VARCHAR</option>
                                    <option value="TEXT">TEXT</option>
                                    <option value="TINYTEXT">TINYTEXT</option>
                                    <option value="MEDIUMTEXT">MEDIUMTEXT</option>
                                    <option value="LONGTEXT">LONGTEXT</option>
                                    <option value="ENUM">ENUM</option>
                                    <option value="SET">SET</option>

                                    <!-- Date/Time -->
                                    <option value="DATE">DATE</option>
                                    <option value="DATETIME">DATETIME</option>
                                    <option value="TIMESTAMP">TIMESTAMP</option>
                                    <option value="TIME">TIME</option>
                                    <option value="YEAR">YEAR</option>
                                </select>

                                </div>
                              </div>

                               <div class="col-lg-2">
                                <div class="form-group">
                                  <!-- <label for=""> Length <span class="text-danger">*</span>:</label> -->
                                  <input type="hidden" class="form-control" name="fields[0][length]" placeholder="Field Length" value="11" readonly>
                                </div>
                              </div>

                              <div class="col-lg-2">
                                <div class="form-group">
                                  <!-- <label for=""> Null <span class="text-danger">*</span>:</label> -->
                                  <input type="hidden" class="form-control" name="fields[0][null]" value="true" readonly>
                                </div>
                              </div>

                                <div class="col-lg-2">
                                <div class="form-group">
                                  <!-- <label for=""> Auto Increment <span class="text-danger">*</span>:</label> -->
                                  <input type="hidden" class="form-control" name="fields[0][auto_increment]" value="true" readonly>
                                </div>
                              </div>

                          </div>

                        </div>
                      </div>

                      <!-- <div class="col-lg-12">
                          <div class="form-group">
                              <button type="button" onclick="addField()"><a href="#"> + Add New Column</a></button>
                          </div>
                      </div> -->

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        
                            <div class="save-btn text-left"> 
                            <button type="button" onclick="addField()"> <a href="javascript:void(0);"><i class="far fa-plus-square"></i> Add New Column</a></button>
                            
                          </div>
                        </div>

                         <div class="col-lg-12">
                             <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                              <div class="save-btn text-right">  
                                 <button type="button" class ="btn btn-primary" onclick="createtable()"> Create Table</button>
                              </div>
                           
                              </div>
                        </div>



  
            </div>
            </div>
        </div>
    </form>
</div>
   
<?php } ?>
  <!-- /.content-header -->
</div>
<!-- common footer include -->
<?php $this->load->view('footer');?>
<?php $this->load->view('common_footer');?>
<?php $this->load->view('commonAddorg_modal');?>
<?php $this->load->view('product_onkeyup');?> 




<script>
let i = 1;

function addField() {
    // Generate a unique ID using timestamp + random
    const uniqueId = 'field_' + Date.now() + '_' + Math.floor(Math.random() * 1000);

    let html = `
    <div class="field-group border p-3 mb-3" id="${uniqueId}">
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label>Column Name<span class="text-danger">*</span>:</label>
                    <input type="text" class="form-control" name="fields[${i}][name]" required>
                </div>
            </div>

           <div class="col-lg-4">
              <div class="form-row d-flex align-items-end">
                  
                  <!-- Type Field -->
                  <div class="col pr-1">
                      <div class="form-group">
                          <label>Type <span class="text-danger">*</span>:</label>
                          <select class="form-control type-select" name="fields[${i}][type]" required>
                              <option value="" selected disabled>Select Field Type</option>

                              <!-- Numeric -->
                              <option value="TINYINT">TINYINT</option>
                              <option value="SMALLINT">SMALLINT</option>
                              <option value="MEDIUMINT">MEDIUMINT</option>
                              <option value="INT">INT</option>
                              <option value="BIGINT">BIGINT</option>
                              <option value="DECIMAL">DECIMAL</option>
                              <option value="FLOAT">FLOAT</option>
                              <option value="DOUBLE">DOUBLE</option>

                              <!-- String -->
                              <option value="CHAR">CHAR</option>
                              <option value="VARCHAR">VARCHAR</option>
                              <option value="TEXT">TEXT</option>
                              <option value="TINYTEXT">TINYTEXT</option>
                              <option value="MEDIUMTEXT">MEDIUMTEXT</option>
                              <option value="LONGTEXT">LONGTEXT</option>
                              <option value="ENUM">ENUM</option>
                              <option value="SET">SET</option>

                              <!-- Date/Time -->
                              <option value="DATE">DATE</option>
                              <option value="DATETIME">DATETIME</option>
                              <option value="TIMESTAMP">TIMESTAMP</option>
                              <option value="TIME">TIME</option>
                              <option value="YEAR">YEAR</option>
                          </select>
                      </div>
                  </div>

                  <!-- Length Field -->
                  <div class="col pl-1 length-wrapper" style="display: none;">
                      <div class="form-group">
                          <label>Length:</label>
                          <input type="text" class="form-control length-input" name="fields[${i}][length]" placeholder="Length">
                      </div>
                  </div>
              </div>
          </div>



            

             <div class="col-lg-2">
                <div class="form-group">
                    <label class ="text-center">Null: </label>
                    <input type="checkbox" class="form-control" name="fields[${i}][null]" value="true"> 
                </div>
            </div>


             <div class="col-lg-1">
                <div class="form-group">
                    
                </div>
            </div>

           

             <div class="col-lg-3 d-flex align-items-end">
                <div class="form-group w-50">
                    <button type="button" onclick="deleteField('${uniqueId}')"> <a href="javascript:void(0);"><i class="far fa-trash-alt delIcn"></i> Delete Row</a></button>
                </div>
            </div>

        </div>

       
    </div>
    `;

    document.getElementById('fields').insertAdjacentHTML('beforeend', html);
    i++;
}

function deleteField(id) {
    const field = document.getElementById(id);
    if (field) {
        field.remove();
    }
}


$(document).ready(function(){
      $("#create_fiels").click(function(){
        $('#create_field').modal('show')
      });

  
});
</script>

<script>
    const typesRequiringLength = ['INT','BIGINT','TINYINT','VARCHAR', 'CHAR', 'DECIMAL', 'FLOAT', 'DOUBLE', 'ENUM', 'SET'];

    document.addEventListener('change', function (e) {
        if (e.target.matches('.type-select')) {
            const selectedType = e.target.value.toUpperCase();
            const wrapper = e.target.closest('.form-row');
            const lengthWrapper = wrapper.querySelector('.length-wrapper');

            if (typesRequiringLength.includes(selectedType)) {
                lengthWrapper.style.display = 'block';

                const input = lengthWrapper.querySelector('.length-input');
                if (['DECIMAL', 'FLOAT', 'DOUBLE'].includes(selectedType)) {
                    input.placeholder = 'Length (e.g., 10,2)';
                } else if (['ENUM', 'SET'].includes(selectedType)) {
                    input.placeholder = `Values (e.g., '1','2')`;
                } else if (['TINYINT'].includes(selectedType)) {
                    input.placeholder = `Values (e.g., '1')`;
                } else {
                    input.placeholder = 'Length (e.g., 255)';
                }
            } else {
                lengthWrapper.style.display = 'none';
                lengthWrapper.querySelector('.length-input').value = '';
            }
        }
    });
</script>




<script>
  function createtable(){

     // Validate Table Name
    var tableName = $('#table_name').val().trim();

    if (tableName === '') {
        toastr.error('Table name is required.');
        $('#table_name').focus();
        return false;
    }

    if (tableName.length < 3) {
        toastr.error('Table name must be at least 3 characters.');
        $('#table_name').focus();
        return false;
    }

    // Optional: Alphanumeric + underscore only
    var regex = /^[a-zA-Z0-9_]+$/;
    if (!regex.test(tableName)) {
        toastr.error('Table name can only contain letters, numbers, and underscores.');
        $('#table_name').focus();
        return false;
    }
      toastr.info('Please wait while we are processing your request');
    
      var url = "<?= base_url('Create_tbl/create_table')?>";
      var dataString = $("#tbl_data").serialize();
      
      
      $.ajax({
        url : url,
        type: "POST",
        data: dataString,
        dataType: "JSON",
        success: function(res)
        {
           if (res.status) {
                 toastr.success(res.message); 
                // location.reload(); // or redirect to another page
            }else {
               toastr.success(res.message); 
               
            }

          

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          toastr.error('Something went wrong, Please try later.');
        }
      });

    
    
  }
</script>



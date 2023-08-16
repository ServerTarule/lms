
    console.log("--leadMasterKeyValueArray---inside lead-editjs file=---",leadMasterKeyValueArray);
    for (const [parentMasterId, childMasterId] of Object.entries(masterDependentObj)) {
        const parentElementId =  `leadMaster_${parentMasterId}`;
        const parentIdValue = $(`#${parentElementId}`).val();
        const masterName = masterDependentObjName[parentMasterId];
        const selectedValue = leadMasterKeyValueArray[childMasterId];
        getDataFromDb(parentIdValue, childMasterId, masterName, selectedValue)
    }

    function getDependentData (event,masterName){
        const selectElement = event.target;
        const parentId = selectElement.value;
        const masterId = $(selectElement).data('masterid');
        const dependentId = masterDependentObj[masterId];
        const dependentName = masterDependentObjName[masterId];
        
        if(parseInt(parentId) > 0) {
            getDataFromDb(parentId, dependentId, dependentName)
        }
    }

    function getDataFromDb(parentId, dependentId, masterName='Option', dependentValueToSelect = 0) {
        const dependentElementId =  `leadMaster_${dependentId}`;
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        const option = `<option value="0">-- Select  ${masterName}--</option>`;
        $(`#${dependentElementId}`).html(`${option}`);
        let selectedText = '';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/getDependentMaster',
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                'parentId': parentId
            },
            dataType: 'JSON',
            success: function (result) {
                let dependentValues = [];
                if(result?.dependentValues) {
                    dependentValues = result?.dependentValues??[];
                   
                    dependentValues.forEach(dependentValue=>{
                        if(dependentValueToSelect == `${dependentValue.id}`) {
                            //selectedText = 'selected';
                        }
                        const option = `<option value="${dependentValue.id}" ${selectedText}>${dependentValue.name} </option>`;
                        $(`#${dependentElementId}`).append(`${option}`);
                    });

                    $(`#${dependentElementId}`).val(`${dependentValueToSelect}`);
                }
            },
            failure: function (result) {
                toastr.error('Error occurred while fetching related data!');
            }
        });
    }

    function getCityForState(stateId, cityId=0) {
        const firstOption = `<option value="0">Select City</option> `;
        $("#city-dropdown").html(`${firstOption}`);
        if(parseInt(stateId) > 0) {
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/getcitiesBystate',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    'stateId': stateId
                },
                dataType: 'JSON',
                success: function (result) {
                    let cities = [];

                    if(result?.cities) {
                        cities = result?.cities??[];
                        cities.forEach(city=>{
                            const option = `<option value="${city.id}">${city.name}</option>`;
                            $("#city-dropdown").append(`${option}`);
                        })
                    }
                    if(cityId > 0) {
                        $("#city-dropdown").val(cityId);
                        getCenterForStateAndCity(selectedCenterId);
                    }
                },
                failure: function (result) {
                    toastr.error('Error occurred while fetching city data!');
                }
            });
        }
    }

    function getCenterForStateAndCity(centerId=0) {
        const stateId = $("#state-dropdown").val();
        const cityId = $("#city-dropdown").val();
        const firstOption = `<option value="0">Select Center</option> `;
        $("#center-detail").html(`${firstOption}`);
        if(parseInt(stateId) > 0  && parseInt(cityId) > 0 ) {
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/centers/getCenterByLocation',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    'stateId': stateId,
                    'cityId': cityId
                },
                dataType: 'JSON',
                success: function (result) {
                    let centers = [];

                    if(result?.centers) {
                        centers = result?.centers??[];
                        centers.forEach(center=>{
                            const option = `<option value="${center.id}">${center.centerDetails}</option>`;
                            $("#center-detail").append(`${option}`);
                        })
                    }
                    if(centerId > 0) {
                        $("#center-detail").val(centerId);
                    }
                
                },
                failure: function (result) {
                    toastr.error('Error occurred while fetching centers data!');
                }
            });
        }
    }

    function validateForm() {
        let name = $('#name').val();
        let email = $('#email').val();
        let mobileno = $('#mobileno').val();
        let receiveddate = $('#receiveddate').val();
        let isValid = true;
        let validationError = "";
        if(!name || name == null) {
            validationError += `<li>Name field is mandatory field.</li>`;
            isValid =false;
        }
        
        if(!mobileno || mobileno == null) {
            validationError += `<li>Mobile number field is mandatory field.</li>`;
            isValid =false;
        }
        else if(mobileno) {
            //don noting
        }
        if(!receiveddate || receiveddate == null) {
            validationError += `<li>Received date field is mandatory field.</li>`;
            isValid =false;
        }
        if(!isValid) {
            toastr.error(validationError);
            bootbox.alert(`${validationError}`);
        }
        return isValid;
    }

    function processSaveLeadInformation() {
        const isValid = validateForm();
        var form_data = new FormData($('#updateLeadForm')[0]);        
        console.log("---form_data-----",form_data);
        if(isValid) {
            let leadMastersData = $('#leadMasters').val();
            let centerId = $('#center-detail').val();
            const leadId =  $("#leadId").val();
            $.each(JSON.parse(leadMastersData), function (key, value) { 
                let $masterValue = $('#leadMaster_' + value.id + ' :selected').val();
                const keyOffArr = `leadMaster_${value.id}`;
                console.log("==keyOffArr===",keyOffArr)
                const valueOfArr = $masterValue?$masterValue:0
                form_data.append(`leadMasterData[${keyOffArr}]`,valueOfArr);
            });
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            form_data.append('_token', CSRF_TOKEN);
            if(isFirstCalling) {
                const stateId = $("#state-dropdown").val();
                const cityId = $("#city-dropdown").val();
                form_data.append(`isFirstCalling`,isFirstCalling);
                form_data.append(`state`,stateId);
                form_data.append(`city`,cityId);
                form_data.append(`centerId`,centerId);
            }
            $.ajax({
                /* the route pointing to the post function */
                url: `/leads/updatelead/${leadId}`,
                type: 'POST',
                data: form_data,
                contentType: false,
                processData: false,
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    let redirectUrl = "/leads";
                    if(isFirstCalling) {
                        redirectUrl = "/leads/calls/"+leadId;
                    }
                    console.log(data,"==redirectUrl==",redirectUrl);
                    if(data.status) {
                        
                        toastr.success(data.message);
                        setTimeout(function(){ 
                            $("#edit-lead-div").toggle();
                            window.location.href = redirectUrl;
                        }, 3000);
                    }
                    else {
                        toastr.error(data.message);
                    }
                    
                    
                    // window.location.href = "/leads";
                },
                error: function (data) {
                    console.log(data);
                    toastr.error(data.message);
                    // window.location.href = "/leads";
                },
                failure: function (data) {
                    console.log(data);
                    toastr.error(data.message);
                }
            });
        
        }
    }

    function showLeadFiles() {
        // $("#lead-files-widget").animate( { "opacity": "toggle",top:"40"} , 1000 );
        $("#lead-files-widget").toggle()

        const text = $("#show-lead-files-icon").html();
        if(text=='Show Files List') {
            $("#show-lead-files-icon").html('Hide Files List');
        }
        else {
            $("#show-lead-files-icon").html('View Files List');
        }
        // $("#lead-files-widget").toggle(function(){
        //     console.log("I am inside callback");
        //     $("#lead-files-widget").animate( { "opacity": "toggle"} , 2000 );
        // });
    }

    $("#leadMasterSubmitUpdate").click(function() {
        // alert("_ I am oe")
        const isValid = validateForm();
        processSaveLeadInformation(); return false;

        var form_data = new FormData($('#updateLeadForm')[0]);
        console.log("---form_data-----",form_data);
        
        if(isValid) {
            let leadMastersData = $('#leadMasters').val();
            let name = $('#name').val();
            let email = $('#email').val();
            let mobileno = $('#mobileno').val();
            let altmobileno = $('#altmobileno').val();
            let receiveddate = $('#receiveddate').val();
            let centerId = $('#center-detail').val();
            console.log("===value of centerId =="+centerId);
            let remark = $('#remark').val();
            let items = {};
            // items[0] = 0;
            const leadId =  $("#leadId").val();
            console.log("----leadMastersData----",leadMastersData);

            


            $.each(JSON.parse(leadMastersData), function (key, value) { 
                let itemValue = {};
                let masterOperations = [];
                let $masterValue = $('#leadMaster_' + value.id + ' :selected').val();
                items['leadMaster_'+value.id] = $masterValue?$masterValue:0;
            });
            console.log("---items--",items);
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const dataToPost = {
                    _token: CSRF_TOKEN,
                    'name': name,
                    'email': email,
                    'mobileno': mobileno,
                    'altmobileno': altmobileno,
                    'receiveddate': receiveddate,
                    'remark': remark,
                    'leadMasterData':items
                };
            if(isFirstCalling) {
                const stateId = $("#state-dropdown").val();
                const cityId = $("#city-dropdown").val();
                dataToPost["isFirstCalling"] = isFirstCalling;
                dataToPost["state"] = stateId;
                dataToPost["city"] = cityId;
                dataToPost["centerId"] = centerId;
            }
            let redirectUrl = "/leads";
            if(isFirstCalling) {
                redirectUrl = "/leads/calls/"+leadId;
            }
            $.ajax({
                /* the route pointing to the post function */
                url: `/leads/updatelead/${leadId}`,
                type: 'POST',
                // contentType: false,
                // processData: false,
                data: dataToPost,
                // data: $(this).serialize(),
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    console.log(data);
                    if(data.status) {
                        toastr.success(data.message);
                    }
                    else {
                        toastr.error(data.message);
                    }
                    setTimeout(function(){ 
                        // window.location.href = redirectUrl;
                    }, 3000);
                },
                error: function (data) {
                    toastr.error(data.message);
                    setTimeout(function(){ 
                        // window.location.href = redirectUrl;
                    }, 3000);
                },
                failure: function (data) {
                    console.log(data);
                }
            });
        
        }
    });

    $("#lead-edit-button").click(function(){
        // alert("---edit-lead-div--===")
        $("#edit-lead-div").toggle(1000);
    });

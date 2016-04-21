$(document).ready(function() {
  $("#form").validate({
    ignore: [],
    rules: {
        name: {required: true,
                remote:{
                    type: 'post',
                    url: '/vuforia/checkFileNameDuplicate',
                    data: {
                        'name': function() {
                            return $("#name").val();
                        }
                    }
                }
            },
        width: {required: true},
        imageLocation: {required: true},
    },
    messages: {
        name: {
            required: "必填欄位",
            remote: "名稱重複"
        },
        width: {
            required: "必填欄位"
        },
        imageLocation: {
            required: "不正確的副檔名格式或未上傳檔案"
        }
    },
    // the Captcha input must only be validated when the whole code string is
    // typed in, not after each individual character (onkeyup must be false)
    onkeyup: false,
    // validate user input when the element loses focus
    onfocusout: function(element) { $(element).valid(); },
    // reload the Captcha image if remote validation failed
    //showErrors: function(errorMap, errorList) {
      //  if (typeof(errorMap.CaptchaCode) != "undefined" &&
      //      errorMap.CaptchaCode === this.settings.messages.CaptchaCode.remote) {
      //    $("#CaptchaCode").get(0).Captcha.ReloadImage();
      //  }
      //  this.defaultShowErrors();
      //},
    success: function(label) {
      //label.text("Ok!");
      //label.addClass(this.validClass);
    },
    errorClass: "incorrect",
    validClass: "correct",
    errorElement: "label"
  });

  $("#formImage").validate({
    rules: {
        file: {required: true, accept:"jpg|jpeg|png"},
    },
    messages: {
        file: {
            required: "請上傳照片",
            accept: "不正確的副檔名格式，只可以上傳照片格式"
        }
    },
      errorClass: "incorrect",
      validClass: "correct",
      errorElement: "label"
  });

  $("#targetImageForm").validate({
      rules: {
          file: {required: true, accept:"jpg|jpeg|png"},
          url: {required: true},
      },
      messages: {
          file: {
              required: "請上傳照片",
              accept: "不正確的副檔名格式，只可以上傳照片格式"
          },
          url: {
              required: "必填欄位"
          }
      },
      errorClass: "incorrect",
      validClass: "correct",
      errorElement: "label"
  });

  $("#targetVideoForm").validate({
      rules: {
          video: {required: true, accept:"mp4|mp3"},
      },
      messages: {
          video: {
              required: "請上傳影片",
              accept: "不正確的副檔名格式，只可以上傳影片格式MP4"
          }
      },
      errorClass: "incorrect",
      validClass: "correct",
      errorElement: "label"
  });

  $("#targetYoutubeForm").validate({
      rules: {
          youtubeUrl: {required: true, remote:{
              type: 'post',
              url: '/vuforia/validateyoutubeurl',
              data: {
                  'youtubeUrl': function() {
                      return $("#youtubeUrl").val();
                  }
              }
          }
          },
      },
      messages: {
          youtubeUrl: {
              required: "請上傳Youtube影片",
              remote: "請上傳有效Youtube影片 例如: https://www.youtube.com/watch?v=c5UGE6Cmm3I "
          }
      },
      errorClass: "incorrect",
      validClass: "correct",
      errorElement: "label"
  })

  $("#createAdminForm").validate({
      rules: {
          name: {required: true},
          account: {required: true},
          email: {required: true,email:true,
              remote:{
                  type: 'post',
                  url: '/vuforia/checkUserNameDuplicate',
                  data: {
                      'email': function() {
                          return $("#email").val();
                      }
                  }
              }
          },
          password: {required: true,minlength:4},
          password_confirmation: {required: true, equalTo: "#password"},
      },
      messages: {
          name: {
              required: "必填欄位"
          },
          account: {
              required: "必填欄位"
          },
          email: {
              required: "必填欄位",
              email: "E-Mail 地址必須是有效E-Mail地址",
              remote:"E-Mail 地址己被使用"
          },
          password: {
              required: "必填欄位",
              minlength: "密碼必須四位以上"
          },
          password_confirmation: {
              required: "必填欄位",
              equalTo: "必須和密碼相同"
          }
      },
      submitHandler: function(form) {
          $("#adminSubmitButton").prop('disabled','true');
          form.submit();
      },
      onkeyup: false,
      errorClass: "incorrect",
      validClass: "correct",
      errorElement: "label"
  })

  $("#createUserForm").validate({
      rules: {
          name: {required: true},
          account: {required: true},
          email: {required: true,email:true,
              remote:{
                  type: 'post',
                  url: '/vuforia/checkUserNameDuplicate',
                  data: {
                      'email': function() {
                          return $("#email").val();
                      }
                  }
              }
          },
          password: {required: true,minlength:4},
          password_confirmation: {required: true, equalTo: "#password"},
      },
      messages: {
          name: {
              required: "必填欄位"
          },
          account: {
              required: "必填欄位"
          },
          email: {
              required: "必填欄位",
              email: "E-Mail 地址必須是有效E-Mail地址",
              remote:"E-Mail 地址己被使用"
          },
          password: {
              required: "必填欄位",
              minlength: "密碼必須四位以上"
          },
          password_confirmation: {
              required: "必填欄位",
              equalTo: "必須和密碼相同"
          }
      },
      submitHandler: function(form) {
          $("#userSubmitButton").prop('disabled','true');
          form.submit();
      },
      onkeyup: false,
      errorClass: "incorrect",
      validClass: "correct",
      errorElement: "label"
  })

  $("#modifyUserForm").validate({
      rules: {
          modifyName: {required: true},
          modifyEmail: {required: true,email:true,
              remote:{
                  type: 'post',
                  url: '/vuforia/checkModifyUserNameDuplicate',
                  data: {
                      'email': function() {
                          return $("#modifyEmail").val();
                      },
                      'id': function() {
                          return $("#modifyId").val();
                      }
                  }
              }
          },
          modifyPassword: {minlength:4},
          modifyPassword_confirmation: {equalTo: "#modifyPassword"},
      },
      messages: {
          modifyName: {
              required: "必填欄位"
          },
          modifyEmail: {
              required: "必填欄位",
              email: "E-Mail 地址必須是有效E-Mail地址",
              remote:"E-Mail 地址己被使用"
          },
          modifyPassword: {
              minlength: "密碼必須四位以上"
          },
          modifyPassword_confirmation: {
              equalTo: "必須和密碼相同"
          }
      },
      onkeyup: false,
      errorClass: "incorrect",
      validClass: "correct",
      errorElement: "label"
  })
});
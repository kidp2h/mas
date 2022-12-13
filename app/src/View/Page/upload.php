<?php $this->style(); ?>
<link rel="stylesheet" href="/resources/css/attendee.css">
<link rel="stylesheet" href="/resources/css/upload.css">
<?php $this->endStyle(); ?>

<?php $this->section('header'); ?>
<div class="wrapFlex">

  <div class="header">
    <a href="/attendee/toppage" class="btn-back">
      <img src="/resources/images/chevron-left.png">
    </a>
    <div class="headerText">
      <h3>Memory Album System</h3>
      <h3>2000 Top page</h3>
    </div>

  </div>
</div>
<?php $this->end(); ?>

<?php $this->section('content'); ?>

<div class="wrapFlex">
  <form id="content" method="post" enctype="multipart/form-data">
    <div class="groupInput">
      <span class="messageValidate" message="imgFile">Message</span>
      <input name="img" type="file" class="inputFileHidden" id="imgFile" accept=".jpg,.jpeg,.png">
      <input type="text" value="写真を選択して下さい select photo" readonly class="inputFileUpload">



    </div>


    <div class="image">
      <img src="" alt="" id="preview" onerror="this.style.display='none'">
      <span>選択した写真</span>
      <span>Selected Photo</span>
    </div>
    <div class="groupInput">
      <span class="messageValidate" message="message">Message</span>
      <textarea name="" id="" cols="30" rows="10" class="message">
メッセージもお願いします
message please
    </textarea>
    </div>

    <div class="groupInput">
      <span class="messageValidate" message="nickname">Message</span>
      <input type="text" value="名前(ニックネーム) Nickname" class="nickname">
    </div>

    <button class="upload" id="upload" type="submit">投稿 upload</button>
  </form>

</div>
<?php $this->end(); ?>

<?php $this->startScript(); ?>
<script>
  let validFile = false;
  let messageValidateFile = "";
  $(".inputFileUpload").addEventListener("click", function() {
    const img = $("#imgFile");
    img.click();

  })
  $("#upload").addEventListener("click", async function(e) {
    e.preventDefault();

    const rules = [{
      selector: "#imgFile",
      required: true
    }, {
      selector: ".message",
      min: 10,
      max: 50,
    }, {
      selector: ".nickname",
      min: 6,
      max: 15,
    }]

    const result = validator(rules);
    if (result === true) {
      const img = $("#imgFile");
      const message = $(".message").value;
      const nickname = $(".nickname").value;

      let form = new FormData();
      form.append("image", img.files[0]);
      form.append("message", message);
      form.append("nickname", nickname);
      const result = await fetch("/attendee/upload", {
        method: "POST",
        body: form,
      })
      if (result.status === 200) {
        const response = await result.json();
        console.log(response);
      } else {
        console.log("error");
      }

    }
  })
  $("#imgFile").addEventListener("change", function() {
    const [file] = this.files
    const preview = $("#preview")
    const validSize = 3000000
    if (file) {
      if (!(/(.*?).png|jpg|jpeg/g.test(file.name))) {
        messageValidateFile = "File is not valid, please upload only image file"
        $(`#imgFile`).previousElementSibling.innerText = messageValidateFile
        $(`#imgFile`)?.previousElementSibling?.classList.add("active")
        $(`#imgFile`).classList.add("error")
      } else if (file.size > validSize) {
        console.log("size");
        messageValidateFile = "File too large, upload image file less than 3MB"
        $(`#imgFile`).previousElementSibling.innerText = messageValidateFile
        $(`#imgFile`)?.previousElementSibling?.classList.add("active")
        $(`#imgFile`).classList.add("error")
      } else {
        const bufferView = new Uint8Array(file)
        console.log(bufferView);
        preview.src = URL.createObjectURL(file)
        $(".inputFileUpload").value = file.name
        $("#preview").style.display = "block";
        $("#imgFile").classList.remove("error")
        $(`#imgFile`)?.previousElementSibling?.classList.remove("active")
      }
    }
  })
</script>
<?php $this->endScript(); ?>;
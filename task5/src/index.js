const btnAddMemberEl = document.querySelector("button");

btnAddMemberEl.addEventListener("click", () => {
  addMember();
});

function validInput(obj) {
  if (/[^а-яё,]/i.test($("#colFormLabelLg").val())) {
    obj.value = obj.value.replace(/[^а-яё,]/i, "");
    $("#exampleModal").modal("show");
    $("#exampleModal").on("shown.bs.modal", () => {
      $("#colFormLabelLg").focus();
    });
  } else {
    $("#exampleModal").modal("hide");
  }
}

$("#colFormLabelLg").keyup((e) => {
  if (e.which == 13) {
    addMember();
  }
});

$("#ok").keyup((e) => {
  if (e.which == 13) {
    return;
  }
});

function addMember() {
  let id;
  let inputName = $("#colFormLabelLg")
    .val()
    .replace(/[^а-яё,]/i, "");
  let membersArr = inputName.split(",");

  $("#exampleTable")
    .removeClass("container d-none")
    .addClass("container d-block");
  //   $("#exampleTable").toggleClass("container d-none container d-block");
  $("#colFormLabelLg").val("");

  ajaxRequest()
    .then((data) => {
      console.log(data);
      for (let i = 0; i < membersArr.length; i++) {
        if (!$(".id")) {
          id = 1;
        } else {
          id = $(".id").length + 1;
        }
        addMemberRow(id, membersArr[i].trim(), data);
      }
    })
    .catch((error) => {
      console.log(error);
    });
}

function ajaxRequest() {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "gen.php",
      type: "POST",
      data: {
        key: "value",
      },
      success: function (data) {
        resolve(data);
      },
      error: function (error) {
        reject(error);
      },
    });
  });
}

function addMemberRow(id, inputName, score) {
  $("#table-rows").append(
    `<tr class="member-row">
        <td class="id">${id}</td>
        <td class="member">${inputName}</td>
        <td class="score">${score}</td>
     </tr>`
  );
}

function sorting(colNumber) {
  let sortingRow = $(".member-row");
  let sortingRowsCount = sortingRow.length;
  let tempStorage = [];
  for (let i = 0; i < sortingRowsCount; i++) {
    tempStorage.push([
      $(sortingRow[i]).find(".id").text(),
      $(sortingRow[i]).find(".member").text(),
      $(sortingRow[i]).find(".score").text(),
    ]);
  }
  $("#table-rows").empty();
  if (colNumber === 0) {
    tempStorage.sort((a, b) => {
      return a[0] - b[0];
    });
  } else {
    tempStorage.sort((a, b) => {
      if (a[colNumber] < b[colNumber]) {
        return -1;
      } else if (a[colNumber] > b[colNumber]) {
        return 1;
      } else {
        return 0;
      }
    });
  }
  tempStorage.join();
  for (let i = 0; i < sortingRowsCount; i++) {
    addMemberRow(tempStorage[i][0], tempStorage[i][1], tempStorage[i][2]);
  }
}

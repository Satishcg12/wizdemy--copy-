// Function to update user status
async function updateUserStatus(userId, element) {
  var status =
    element.getAttribute("data-status") == "suspend" ? "active" : "suspend";

  // Open the confirmation modal and wait for user action
  const confirmed = await openConfirmModal(
    status,
    `Approve "${status}" for this User ?`
  );

  // If user cancels the action, do nothing
  if (!confirmed) {
    return false;
  }

  // Proceed with the action
  var data = {
    user_id: userId,
    status: status,
  };
  $.ajax({
    type: "POST",
    url: "/api/admin/update/users/status",
    data: data,
    success: function (response) {
      console.log(response);
      if (response.status == 200 && status == "active") {
        element.setAttribute("data-status", "active");
      } else {
        element.setAttribute("data-status", "suspend");
      }
    },
  });
}

// Function to update user status
async function deleteUser(userId, element) {
  var status = "delete";
  // Open the confirmation modal and wait for user action
  const confirmed = await openConfirmModal(
    status,
    `Approve "${status}" for this User ?`
  );

  // If user cancels the action, do nothing
  if (!confirmed) {
    return false;
  }
  $.ajax({
    type: "DELETE",
    url: "/api/admin/delete/user/" + userId,
    success: function (response) {
      console.log(response);
      if (response.status == 200) {
        // element closest tr
        element.closest("tr").remove();
      }
    },
  });
}

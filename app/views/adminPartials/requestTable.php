<?php //dd($requests); ?>
<div class="table-menus">
  <form action="#" method="GET">
    <div class="search-field">
      <input type="text" name="query" id="table-search-input"
        placeholder="Search ' REQUESTS '&nbsp;&nbsp;&#x2044;&nbsp;&nbsp;or&nbsp;&nbsp;🄲🅃🅁🄻 +  🄺"
        class="search-input" value="<?= $query ?? '' ?>">
    </div>
  </form>
  <div class="prev-next-wrapper">
    <a class="prev-btn <?= $page == 1 ? 'disabled' : '' ?>"
      href="/admin/manage/request?page=<?= $page - 1 ? $page - 1 : 1 ?>&query=<?= $query ?>">
      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
        <g id="SVGRepo_iconCarrier">
          <path
            d="M16.1795 3.26875C15.7889 2.87823 15.1558 2.87823 14.7652 3.26875L8.12078 9.91322C6.94952 11.0845 6.94916 12.9833 8.11996 14.155L14.6903 20.7304C15.0808 21.121 15.714 21.121 16.1045 20.7304C16.495 20.3399 16.495 19.7067 16.1045 19.3162L9.53246 12.7442C9.14194 12.3536 9.14194 11.7205 9.53246 11.33L16.1795 4.68297C16.57 4.29244 16.57 3.65928 16.1795 3.26875Z"
            fill="currentColor"></path>
        </g>
      </svg>
    </a>
    <a class="next-btn <?= $page * 10 >= $totalData ? 'disabled' : '' ?>"
      href="/admin/manage/request?page=<?= $page + 1 ?>&query=<?= $query ?>">
      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
        <g id="SVGRepo_iconCarrier">
          <path
            d="M7.82054 20.7313C8.21107 21.1218 8.84423 21.1218 9.23476 20.7313L15.8792 14.0868C17.0505 12.9155 17.0508 11.0167 15.88 9.84497L9.3097 3.26958C8.91918 2.87905 8.28601 2.87905 7.89549 3.26958C7.50497 3.6601 7.50497 4.29327 7.89549 4.68379L14.4675 11.2558C14.8581 11.6464 14.8581 12.2795 14.4675 12.67L7.82054 19.317C7.43002 19.7076 7.43002 20.3407 7.82054 20.7313Z"
            fill="currentColor"></path>
        </g>
      </svg>
    </a>
    <div class="table-info">

      <?= ($page - 1) * 10 + 1 ?>
      - <?= ($page - 1) * 10 + count($requests) ?>
      of <?= $totalData ?? 0 ?>
    </div>
  </div>
</div>

<div class="table-section">
  <table>
    <thead>
      <tr>
        <th>
          User
        </th>
        <th>
          Details
        </th>
        <th>
          Meta Datas
        </th>
        <th>
          Dates
        </th>
        <th>
          Action
        </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($requests as $request):
        ?>
        <tr>
          <td>
            <p title="Uploaded By : <?= $request['username'] ?> | Click to View">
              <a href="/admin/view/user/<?= $request['user_id'] ?>">
                User:&nbsp;<?= $request['username'] ?>
              </a>
            </p>
            <span title="No of Responds : <?= $request['no_of_materials'] ?>">
              Responds Received:&nbsp;<?= $request['no_of_materials'] ?>
            </span><br>
          </td>
          <td class="post-details">
            <p title="Title: <?= $request['title'] ?>" class="title">
              Title:&nbsp;<?= $request['title'] ?>
            </p>
            <span title="Description: <?= $request['description'] ?>" class="description">
              Description:&nbsp;<?= $request['description'] ?>
            </span>
          </td>
          <td class="meta-datas">
            <p title="Subject: <?= $request['subject'] ?>" class="subject">
              Subject:&nbsp;<?= $request['subject'] ?>
            </p>
            <div class="multi-span">
              <span title="Education Level: <?= $request['education_level'] ?>">
                Edu Lvl:&nbsp;<?= $request['education_level'] ?>
              </span>
              <span title="class/faclty: <?= $request['class_faculty'] ?>">
                Class/Faculty:&nbsp;<?= $request['class_faculty'] ?>
              </span>
              <?php if ($request['semester'] != ''): ?>
                <span title="Semester: <?= $request['semester'] ?>">
                  Sem:&nbsp;<?= $request['semester'] ?>
                </span>
              <?php endif ?>
            </div>
            <div class="multi-span">
              <span title="Dcoument Type: <?= $request['document_type'] ?>">
                Doc Type:&nbsp;<?= $request['document_type'] ?>
              </span>

            </div>
          </td>
          <td>
            <p title="Last Updated: <?= $request['updated_at'] ?>">
              Updated:&nbsp;<?= date('d M Y', strtotime($request['updated_at'])) ?>
            </p>
            <span title="Joined At: <?= $request['created_at'] ?>">
              Created:&nbsp;<?= date('d M Y', strtotime($request['created_at'])) ?>
            </span>
          </td>
          <td class="actions-cell">
            <div>
              <!-- suspend button  -->
              <button class="suspend-btn  <?= $request['status'] == 'suspend' ? 'active' : '' ?>" data-status="<?= $request['status'] == 'suspend' ? 'active' : 'suspend' ?>"
                onclick="updateStatus('request',<?= $request['request_id'] ?>, this)">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                  <g fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" d="M16 12H8" />
                    <circle cx="12" cy="12" r="10" />
                  </g>
                </svg>
              </button>
              <!-- delete button  -->
              <button class="delete-btn" onclick="deleteData('request',<?= $request['request_id'] ?>,this)">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                  <path fill="currentColor" fill-rule="evenodd"
                    d="M10.31 2.25h3.38c.217 0 .406 0 .584.028a2.25 2.25 0 0 1 1.64 1.183c.084.16.143.339.212.544l.111.335a1.25 1.25 0 0 0 1.263.91h3a.75.75 0 0 1 0 1.5h-17a.75.75 0 0 1 0-1.5h3.09a1.25 1.25 0 0 0 1.173-.91l.112-.335c.068-.205.127-.384.21-.544a2.25 2.25 0 0 1 1.641-1.183c.178-.028.367-.028.583-.028m-1.302 3a2.757 2.757 0 0 0 .175-.428l.1-.3c.091-.273.112-.328.133-.368a.75.75 0 0 1 .547-.395a3.2 3.2 0 0 1 .392-.009h3.29c.288 0 .348.002.392.01a.75.75 0 0 1 .547.394c.021.04.042.095.133.369l.1.3l.039.112c.039.11.085.214.136.315z"
                    clip-rule="evenodd" />
                  <path fill="currentColor"
                    d="M5.915 8.45a.75.75 0 1 0-1.497.1l.464 6.952c.085 1.282.154 2.318.316 3.132c.169.845.455 1.551 1.047 2.104c.591.554 1.315.793 2.17.904c.822.108 1.86.108 3.146.108h.879c1.285 0 2.324 0 3.146-.108c.854-.111 1.578-.35 2.17-.904c.591-.553.877-1.26 1.046-2.104c.162-.813.23-1.85.316-3.132l.464-6.952a.75.75 0 0 0-1.497-.1l-.46 6.9c-.09 1.347-.154 2.285-.294 2.99c-.137.685-.327 1.047-.6 1.303c-.274.256-.648.422-1.34.512c-.713.093-1.653.095-3.004.095h-.774c-1.35 0-2.29-.002-3.004-.095c-.692-.09-1.066-.256-1.34-.512c-.273-.256-.463-.618-.6-1.302c-.14-.706-.204-1.644-.294-2.992z" />
                  <path fill="currentColor"
                    d="M9.425 10.254a.75.75 0 0 1 .821.671l.5 5a.75.75 0 0 1-1.492.15l-.5-5a.75.75 0 0 1 .671-.821m5.15 0a.75.75 0 0 1 .671.82l-.5 5a.75.75 0 0 1-1.492-.149l.5-5a.75.75 0 0 1 .82-.671" />
                </svg>
              </button>
            </div>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>
<?php

<?php View::renderPartial('../adminPartials/tableMenu', [
  'currentData' => count($materials),
  'page' => $page,
  'totalData' => $totalData,
  'query' => $query,
  'table_type' => 'materials',
]); ?>

<div class="table-section">
  <table>
    <thead>
      <tr>
        <th>
          Thumbnail
        </th>
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
          interactions
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
      <?php foreach ($materials as $material):
        ?>
        <tr>
          <td class="thumbnail-td">
            <div class="thumbnail"
              title="Title:&#10;&#10;<?= $material['title'] ?>&#10;&#10;Description:&#10;&#10;<?= $material['description'] ?>">
              <img src="/<?= $material['thumbnail_path'] ?>" alt="material thumbnail">
            </div>
          </td>
          <td>
            <p title="Uploaded By : <?= $material['username'] ?> | Click to View">
              <a href="/admin/view/user/<?= $material['user_id'] ?>">
                User:&nbsp;<?= $material['username'] ?>
              </a>
            </p>
            <span title="Author | Source | Credits : <?= $material['author'] ?>">
              A | S | C:&nbsp;<?= $material['author'] ?>
            </span><br>
            <?php if ($material['responded_to'] != ''): ?>
              <a href="/admin/view/request/<?= $material['request_id'] ?>">
                Responded To:&nbsp;<?= $material['responded_to'] ?>
              </a>
            <?php endif ?>
          </td>
          <td class="post-details">
            <p title="Title: <?= $material['title'] ?>" class="title">
              Title:&nbsp;<?= $material['title'] ?>
            </p>
            <span title="Description: <?= $material['description'] ?>" class="description">
              Description:&nbsp;<?= $material['description'] ?>
            </span>
          </td>
          <td class="meta-datas">
            <p title="Subject: <?= $material['subject'] ?>" class="subject">
              Subject:&nbsp;<?= $material['subject'] ?>
            </p>
            <div class="multi-span">
              <span title="Education Level: <?= $material['education_level'] ?>">
                Edu Lvl:&nbsp;<?= $material['education_level'] ?>
              </span>
              <span title="class/faclty: <?= $material['class_faculty'] ?>">
                Class/Faculty:&nbsp;<?= $material['class_faculty'] ?>
              </span>
              <?php if ($material['semester'] != ''): ?>
                <span title="Semester: <?= $material['semester'] ?>">
                  Sem:&nbsp;<?= $material['semester'] ?>
                </span>
              <?php endif ?>
            </div>
            <div class="multi-span">
              <span title="Dcoument Type: <?= $material['document_type'] ?>">
                Doc Type:&nbsp;<?= $material['document_type'] ?>
              </span>
              <span title="Format: <?= $material['format'] ?>">
                Format:&nbsp;<?= $material['format'] ?>
              </span>
            </div>
          </td>
          <td class="interactions">
            <span title="Views: <?= $material['views_count'] ?>">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                </path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                </path>
              </svg>:&nbsp;<?= $material['views_count'] ?>
            </span>
            <br> <span title="Likes: <?= $material['likes_count'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="256"
                height="256" viewBox="0 0 256 256">
                <path fill="currentColor"
                  d="M178 28c-20.09 0-37.92 7.93-50 21.56C115.92 35.93 98.09 28 78 28a66.08 66.08 0 0 0-66 66c0 72.34 105.81 130.14 110.31 132.57a12 12 0 0 0 11.38 0C138.19 224.14 244 166.34 244 94a66.08 66.08 0 0 0-66-66m-5.49 142.36a328.69 328.69 0 0 1-44.51 31.8a328.69 328.69 0 0 1-44.51-31.8C61.82 151.77 36 123.42 36 94a42 42 0 0 1 42-42c17.8 0 32.7 9.4 38.89 24.54a12 12 0 0 0 22.22 0C145.3 61.4 160.2 52 178 52a42 42 0 0 1 42 42c0 29.42-25.82 57.77-47.49 76.36">
                </path>
              </svg>:&nbsp;
              <?= $material['likes_count'] ?>
            </span>
            <br> <span title="Comments: <?= $material['comments_count'] ?>"><svg viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                  <path d="M7 7H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  </path>
                  <path d="M7 11H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                  </path>
                  <path
                    d="M19 3H5C3.89543 3 3 3.89543 3 5V15C3 16.1046 3.89543 17 5 17H8L11.6464 20.6464C11.8417 20.8417 12.1583 20.8417 12.3536 20.6464L16 17H19C20.1046 17 21 16.1046 21 15V5C21 3.89543 20.1046 3 19 3Z"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </g>
              </svg>:&nbsp;
              <?= $material['comments_count'] ?>
            </span>
          </td>
          <td>
            <p title="Last Updated: <?= $material['updated_at'] ?>">
              Updated:&nbsp;<?= date('d M Y', strtotime($material['updated_at'])) ?>
            </p>
            <span title="Joined At: <?= $material['created_at'] ?>">
              Created:&nbsp;<?= date('d M Y', strtotime($material['created_at'])) ?>
            </span>
          </td>
          <td class="actions-cell">
            <div>

            <button title="View PDF"
            data-document-path="/<?= $material['file_path'] ?>" class="view-pdf-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"><path d="M5.25 14.5a.75.75 0 0 1 .75-.75h8a.75.75 0 1 1 0 1.5H6a.75.75 0 0 1-.75-.75m0 3.5a.75.75 0 0 1 .75-.75h5.5a.75.75 0 0 1 0 1.5H6a.75.75 0 0 1-.75-.75"/><path d="M12.25 2.834c-.46-.078-1.088-.084-2.22-.084c-1.917 0-3.28.002-4.312.14c-1.012.135-1.593.39-2.016.812c-.423.423-.677 1.003-.812 2.009c-.138 1.028-.14 2.382-.14 4.29v4c0 1.906.002 3.26.14 4.288c.135 1.006.389 1.586.812 2.01c.423.422 1.003.676 2.009.811c1.028.139 2.382.14 4.289.14h4c1.907 0 3.262-.002 4.29-.14c1.005-.135 1.585-.389 2.008-.812c.423-.423.677-1.003.812-2.009c.138-1.027.14-2.382.14-4.289v-.437c0-1.536-.01-2.264-.174-2.813h-3.13c-1.133 0-2.058 0-2.79-.098c-.763-.103-1.425-.325-1.954-.854c-.529-.529-.751-1.19-.854-1.955c-.098-.73-.098-1.656-.098-2.79zm1.5.776V5c0 1.2.002 2.024.085 2.643c.08.598.224.891.428 1.094c.203.204.496.348 1.094.428c.619.083 1.443.085 2.643.085h2.02a45.815 45.815 0 0 0-1.17-1.076l-3.959-3.563A37.2 37.2 0 0 0 13.75 3.61m-3.575-2.36c1.385 0 2.28 0 3.103.315c.823.316 1.485.912 2.51 1.835l.107.096l3.958 3.563l.125.112c1.184 1.065 1.95 1.754 2.361 2.678c.412.924.412 1.954.411 3.546v.661c0 1.838 0 3.294-.153 4.433c-.158 1.172-.49 2.121-1.238 2.87c-.749.748-1.698 1.08-2.87 1.238c-1.14.153-2.595.153-4.433.153H9.944c-1.838 0-3.294 0-4.433-.153c-1.172-.158-2.121-.49-2.87-1.238c-.748-.749-1.08-1.698-1.238-2.87c-.153-1.14-.153-2.595-.153-4.433V9.945c0-1.838 0-3.294.153-4.433c.158-1.172.49-2.121 1.238-2.87c.75-.749 1.701-1.08 2.878-1.238c1.144-.153 2.607-.153 4.455-.153h.056z"/></g></svg>
            </button>
              <!-- suspend button  -->
              <button title="Suspend"
               class="suspend-btn  <?= $material['status'] == 'suspend' ? 'active' : '' ?>"
                data-status="<?= $material['status'] == 'suspend' ? 'active' : 'suspend' ?>"
                onclick="updateStatus('material',<?= $material['material_id'] ?>,this)">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                  <g fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" d="M16 12H8" />
                    <circle cx="12" cy="12" r="10" />
                  </g>
                </svg>
              </button>
              <!-- delete button  -->
              <button title="Delete"
               class="delete-btn" onclick="deleteData('material',<?= $material['material_id'] ?>,this)">
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

<!-- overlay of the pdf  -->
<div class="pdf-overlay" id="pdf-overlay">
    <div class="pdf-popup" id="pdf-popup">
        <iframe class="pdf-iframe" id="pdf-iframe" src="" loading="lazy"></iframe>
    </div>
</div>

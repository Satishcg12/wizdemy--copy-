<?php View::renderPartial('../adminPartials/tableMenu', [
  'currentData' => count($reports),
  'page' => $page,
  'totalData' => $totalData,
  'query' => $query,
  'table_type' => 'reports',
]); ?>


<div class="table-section">
  <table>
    <thead>
      <tr>
        <th>
          User (Reported By)
        </th>
        <th>
          Target Type
        </th>
        <th>
          Details
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
      <?php foreach ($reports as $report): ?>
        <tr>
          <td>
            <p title="Username | Click to View">
              <a href="/admin/view/user/<?= $report['user_id'] ?>">
                <?= $report['username'] ?>
              </a>
            </p>
            <a href="mailto:<?= $report['email'] ?>">
              <?= $report['email'] ?>
            </a>
          </td>
          <td>
            <div class="target_type">
              <p>
                <?= $report['target_type'] ?>
              </p>
            </div>
          </td>
          <td class="post-details">
            <p title="Title: <?= $report['title'] ?>" class="title">
              Title:&nbsp;<?= $report['title'] ?>
            </p>
            <span title="Description: <?= $report['description'] ?>" class="description">
              Description:&nbsp;<?= $report['description'] ?>
            </span>
          </td>
          <!-- <td>
            <div class="status">
              <p>
                <?= $report['status'] ?>
              </p>
            </div>
          </td> -->
          <td>
            <p title="Last Updated: <?= $report['updated_at'] ?>">
              Updated:&nbsp;<?= date('d M Y', strtotime($report['updated_at'])) ?>
            </p>
            <span title="Joined At: <?= $report['created_at'] ?>">
              Created:&nbsp;<?= date('d M Y', strtotime($report['created_at'])) ?>
            </span>
          </td>
          <td class="actions-cell">
            <div>
              <!-- view button  to view the target -->
              <a title="View Target"
              href="/admin/view/<?= $report['target_type'] ?>/<?= $report['target_id'] ?>" class="view-btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                  <g fill="currentColor" fill-rule="evenodd" clip-rule="evenodd">
                    <path
                      d="M12 8.25a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5M9.75 12a2.25 2.25 0 1 1 4.5 0a2.25 2.25 0 0 1-4.5 0" />
                    <path
                      d="M12 3.25c-4.514 0-7.555 2.704-9.32 4.997l-.031.041c-.4.519-.767.996-1.016 1.56c-.267.605-.383 1.264-.383 2.152c0 .888.116 1.547.383 2.152c.25.564.617 1.042 1.016 1.56l.032.041C4.445 18.046 7.486 20.75 12 20.75c4.514 0 7.555-2.704 9.32-4.997l.031-.041c.4-.518.767-.996 1.016-1.56c.267-.605.383-1.264.383-2.152c0-.888-.116-1.547-.383-2.152c-.25-.564-.617-1.041-1.016-1.56l-.032-.041C19.555 5.954 16.514 3.25 12 3.25M3.87 9.162C5.498 7.045 8.15 4.75 12 4.75c3.85 0 6.501 2.295 8.13 4.412c.44.57.696.91.865 1.292c.158.358.255.795.255 1.546s-.097 1.188-.255 1.546c-.169.382-.426.722-.864 1.292C18.5 16.955 15.85 19.25 12 19.25c-3.85 0-6.501-2.295-8.13-4.412c-.44-.57-.696-.91-.865-1.292c-.158-.358-.255-.795-.255-1.546s.097-1.188.255-1.546c.169-.382.426-.722.864-1.292" />
                  </g>
                </svg>
              </a>
              <!-- pending button / indicator -->
              <button title="Pending"
               class="pending-btn <?= $report['status'] == 'pending' ? 'active' : '' ?>
               " data-status="pending" onclick="updateStatus('report',<?= $report['report_id'] ?>, this)">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                  <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="1.6"
                    d="M10 9v6m4-6v6M3 9.4c0-2.24 0-3.36.436-4.216a4 4 0 0 1 1.748-1.748C6.04 3 7.16 3 9.4 3h5.2c2.24 0 3.36 0 4.216.436a4 4 0 0 1 1.748 1.748C21 6.04 21 7.16 21 9.4v5.2c0 2.24 0 3.36-.436 4.216a4 4 0 0 1-1.748 1.748C17.96 21 16.84 21 14.6 21H9.4c-2.24 0-3.36 0-4.216-.436a4 4 0 0 1-1.748-1.748C3 17.96 3 16.84 3 14.6z" />
                </svg>
              </button>
              <!-- resolved / completed / acted / action taken button  -->
              <button title="Resolved"
               class="resolved-btn <?= $report['status'] == 'resolved' ? 'active' : '' ?>" data-status="resolved"
                onclick="updateStatus('report',<?= $report['report_id'] ?>, this)">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                  <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="1.6" d="M18 6L7 17l-5-5m20-2l-7.5 7.5L13 16" />
                </svg>
              </button>
            </div>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>

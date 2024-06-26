<?php View::renderPartial('../adminPartials/tableMenu', [
  'currentData' => count($logs),
  'page' => $page,
  'totalData' => $totalData,
  'query' => $query,
  'table_type' => $currentPage == 'adminLog' ? 'admins action log' : 'my actions',
]); ?>


<div class="table-section">
  <table>
    <thead>
      <tr>
        <th>
          Admin
        </th>
        <th>
          Target Type
        </th>
        <th>

          Action Performed
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
      <?php foreach ($logs as $log): ?>
        <tr>
          <td>
            <p title="Admin Username | Click to View">
              <a href="<?= $currentPage == 'adminLog' ? '/admin/view/admin/' . $log['admin_id'] : '#' ?>">
                <?= $log['admin_username'] ?>
              </a>
            </p>
            <a href="mailto:<?= $log['admin_email'] ?>">
              <?= $log['admin_email'] ?>
            </a>
          </td>
          <td>
            <div class="target_type">
              <p>
                <?= $log['target_type'] ?>
              </p>
            </div>
          </td>
          <td>
            <div class="action_type">
              <p>
                <?= $log['action_type'] ?>
              </p>
            </div>
          </td>
          <td>
            <p title="Last Updated: <?= $log['updated_at'] ?>">
              Updated:&nbsp;<?= date('d M Y', strtotime($log['updated_at'])) ?>
            </p>
            <span title="Joined At: <?= $log['created_at'] ?>">
              Created:&nbsp;<?= date('d M Y', strtotime($log['created_at'])) ?>
            </span>
          </td>
          <td class="actions-cell">
            <?php if ($log['action_type'] != 'delete'): ?>
              <div>
                <!-- view button  to view the target -->
                <a title="View Target"
                 href="/admin/view/<?= $log['target_type'] ?>/<?= $log['target_id'] ?>" class="view-btn">
                  <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                    <g fill="currentColor" fill-rule="evenodd" clip-rule="evenodd">
                      <path
                        d="M12 8.25a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5M9.75 12a2.25 2.25 0 1 1 4.5 0a2.25 2.25 0 0 1-4.5 0" />
                      <path
                        d="M12 3.25c-4.514 0-7.555 2.704-9.32 4.997l-.031.041c-.4.519-.767.996-1.016 1.56c-.267.605-.383 1.264-.383 2.152c0 .888.116 1.547.383 2.152c.25.564.617 1.042 1.016 1.56l.032.041C4.445 18.046 7.486 20.75 12 20.75c4.514 0 7.555-2.704 9.32-4.997l.031-.041c.4-.518.767-.996 1.016-1.56c.267-.605.383-1.264.383-2.152c0-.888-.116-1.547-.383-2.152c-.25-.564-.617-1.041-1.016-1.56l-.032-.041C19.555 5.954 16.514 3.25 12 3.25M3.87 9.162C5.498 7.045 8.15 4.75 12 4.75c3.85 0 6.501 2.295 8.13 4.412c.44.57.696.91.865 1.292c.158.358.255.795.255 1.546s-.097 1.188-.255 1.546c-.169.382-.426.722-.864 1.292C18.5 16.955 15.85 19.25 12 19.25c-3.85 0-6.501-2.295-8.13-4.412c-.44-.57-.696-.91-.865-1.292c-.158-.358-.255-.795-.255-1.546s.097-1.188.255-1.546c.169-.382.426-.722.864-1.292" />
                    </g>
                  </svg>
                </a>
              </div>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>

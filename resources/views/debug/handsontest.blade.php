<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test Gradebook</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable@13.0.0/dist/handsontable.full.min.css" />
</head>
<body>
    <div id="gradebook-table" style="margin: 20px;"></div>

    <script src="https://cdn.jsdelivr.net/npm/handsontable@13.0.0/dist/handsontable.full.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('gradebook-table');

            let labels = ['Quiz 1', 'Activity 1'];
            const data = [
                { Name: 'John', student_id: 1, 'Quiz 1': 80, 'Activity 1': 90 },
                { Name: 'Jane', student_id: 2, 'Quiz 1': 85, 'Activity 1': 88 }
            ];

            function getColumns() {
                return [{ data: 'Name', readOnly: true }].concat(
                    labels.map(label => ({ data: label, type: 'numeric' }))
                );
            }

            function getHeaders() {
                return ['Name', ...labels];
            }

            const hot = new Handsontable(container, {
                data: data,
                columns: getColumns(),
                colHeaders: getHeaders(),
                rowHeaders: true,
                width: '100%',
                height: 400,
                stretchH: 'all',
                licenseKey: 'non-commercial-and-evaluation',
                contextMenu: {
                    items: {
                        rename_column: {
                            name: 'Rename column',
                            callback: function (_, options) {
                                alert('rename clicked'); // Confirm it's firing
                            }
                        },
                        delete_column: {
                            name: 'Delete column',
                            callback: function (_, options) {
                                alert('delete clicked');
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>

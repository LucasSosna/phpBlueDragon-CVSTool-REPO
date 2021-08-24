using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace csvtooldesktop
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }

        private void button2_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private string[] linesOfFile;

        private string TrimMyString(string MyValue)
        {
            return MyValue;
        }
        
        private void buttonSelectFile_Click(object sender, EventArgs e)
        {
            var fileContent = string.Empty;
            var filePath = string.Empty;

            using (OpenFileDialog openFileDialog = new OpenFileDialog())
            {
                //openFileDialog.InitialDirectory = "c:\\";
                openFileDialog.Filter = "CSV files (*.csv)|*.csv|TXT files (*.txt)|*.txt";
                //openFileDialog.FilterIndex = 2;
                openFileDialog.RestoreDirectory = true;

                if (openFileDialog.ShowDialog() == DialogResult.OK)
                {
                    filePath = openFileDialog.FileName;

                    var fileStream = openFileDialog.OpenFile();

                    textBoxFile.Text = filePath;

                    /*using (StreamReader reader = new StreamReader(fileStream))
                    {
                        fileContent = reader.ReadToEnd();
                    }*/

                    linesOfFile = File.ReadAllLines(filePath);
                }
            }
        }

        private void buttonMakeTable_Click(object sender, EventArgs e)
        {
            string OutPut = "";

            if (textBoxSeparator.Text == "")
            {
                MessageBox.Show("No sign of record division.", "CVSToolDesign", MessageBoxButtons.OK);
            }
            else
            {
                if (textBoxFile.Text == "")
                {
                    MessageBox.Show("No file has been added.", "CVSToolDesign", MessageBoxButtons.OK);
                }
                else
                {
                    OutPut = "<table>\r\n";

                    foreach (string oneLine in linesOfFile)
                    {
                        string[] ElementsOfLine = oneLine.Split(textBoxSeparator.Text[0]);

                        OutPut += "<tr>\r\n";

                        foreach (string oneCharLines in ElementsOfLine)
                        {
                            OutPut += "<td>" + oneCharLines + "</td>\r\n";
                        }

                        OutPut += "</tr>\r\n";
                    }

                    OutPut += "</table>";

                    textBoxOutFile.Text = OutPut;
                }
            }
        }

        private void exitToolStripMenuItem_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void wWWToolStripMenuItem1_Click(object sender, EventArgs e)
        {
            System.Diagnostics.Process.Start("http://phpbluedragon.eu/");
        }

        private void aboutToolStripMenuItem_Click(object sender, EventArgs e)
        {
            System.Diagnostics.Process.Start("http://phpbluedragon.eu/");
        }
    }
}

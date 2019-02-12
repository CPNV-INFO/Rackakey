using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.IO;
using System.IO.Ports;
using System.Collections.ObjectModel;
using System.Management;
using USBClassLibrary;
using System.Runtime.InteropServices;



namespace ListDevices
{
    public partial class Form1 : Form
    {
        #region Const
        private const string USB_DEVICE_NAME = "Dispositif de stockage de masse USB";
        #endregion

        #region class
        private Thread thread;
        private DbConnection db;
        #endregion

        #region delegate
        delegate void GetResponse(List<string> stringList);
        #endregion


        
        #region public methods
        /// <summary>
        /// Constructor of Form1
        /// </summary>
        public Form1()
        {
            InitializeComponent();
        }
        #endregion

        #region private methods
        private void Form1_Load(object sender, EventArgs e)
        {
            //create a new thread who check if a usb device is connected
            thread = new Thread(GetDevices);
            thread.Start();

            //create a new DB connection
            db = new DbConnection();

           

        }


        /// <summary>
        /// Get the usb devices and add it to the list
        /// </summary>
        private void GetDevices()
        {
            List<string> devices = new List<string>();
         

            while(true)
            {
                devices.Clear();

                try
                { 
                    foreach (DriveInfo drive in DriveInfo.GetDrives())
                    {
                        // if the device is an removable device (USB, external drive), add it to the list
                        if (drive.DriveType == DriveType.Removable)
                        {
                            devices.Add(string.Format("({0}) {1}", drive.Name.Replace("\\", ""), drive.VolumeLabel));

                            UsbKey usbKey = new UsbKey(drive.VolumeLabel, "null", (UInt64)drive.AvailableFreeSpace, DateTime.Now.ToString("yyyy-MM-dd HH:mm"));

                            db.AddUsbKey(usbKey); //try to add a usb in DB      
                        }
                    }


                }
                catch(Exception exc)
                {
                    Console.WriteLine("L'exception suivante est apparue : " + exc.Message);
                }
                

                try
                { 
                    Invoke((GetResponse)DisplayResponse, devices);
                }
                catch (Exception exc)
                {
                    Console.WriteLine("L'exception suivante est apparue : " + exc.Message);
                }
            }
            
        }

        /// <summary>
        /// Display the actual devices on the listbox
        /// </summary>
        /// <param name="devices"></param>
        private void DisplayResponse(List<string> devices)
        {
            //if the number of usb devices is different : clean the list of devices
            if(devices.Count != lstDevices.Items.Count)
            {
                lstDevices.DataSource = null;
            }

            lstDevices.DataSource = devices;
        }


        /// <summary>
        /// Event when the form is under closing
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void Form1_FormClosing(object sender, FormClosingEventArgs e)
        {
            thread.Abort();
        }

        #endregion
    }
}

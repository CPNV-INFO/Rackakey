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




namespace ListDevices
{
    public partial class Form1 : Form
    {
        #region Const
        const string USB_DEVICE_NAME = "Dispositif de stockage de masse USB";
        #endregion

        #region class
        Thread thread;
        DbConnection db;
        USBClass USBPort;
        #endregion

        #region delegate
        delegate void GetResponse(List<string> stringList);
        #endregion

        #region variables
        List<USBClass.DeviceProperties> ListOfUSBDeviceProperties;
        bool MyUSBDeviceConnected;
        #endregion

        /// <summary>
        /// Constructor of Form1
        /// </summary>
        public Form1()
        {
            InitializeComponent();
        }

        #region private methods
        private void Form1_Load(object sender, EventArgs e)
        {
            //create a new thread who check if a usb device is connected
            thread = new Thread(GetDevices);
            thread.Start();

            //create a new DB connection
            db = new DbConnection();

            //USB Connection
            USBPort = new USBClass();
            ListOfUSBDeviceProperties = new List<USBClass.DeviceProperties>();
           // USBPort.USBDeviceAttached += new USBClass.USBDeviceEventHandler(USBPort_USBDeviceAttached);
            //USBPort.USBDeviceRemoved += new USBClass.USBDeviceEventHandler(USBPort_USBDeviceRemoved);
            USBPort.RegisterForDeviceChange(true, this.Handle);
          //  USBTryMyDeviceConnection();
            MyUSBDeviceConnected = false;
        }

        public List<USBDeviceInfo> GetUSBDevices()
        {
            List<USBDeviceInfo> devices = new List<USBDeviceInfo>();

            ManagementObjectCollection collection;
            using (var searcher = new ManagementObjectSearcher(@"Select * From Win32_USBHub"))
                collection = searcher.Get();

            foreach (var device in collection)
            {
                devices.Add(new USBDeviceInfo(
                (string)device.GetPropertyValue("DeviceID"),
                (string)device.GetPropertyValue("Name")
                ));
            }

            collection.Dispose();
            return devices;
        }


        /// <summary>
        /// Get the usb devices and add it to the list
        /// </summary>
        private void GetDevices()
        {
            List<string> devices = new List<string>();
            string VID = "";
            string PID = "";

            while(true)
            {
                devices.Clear();

                try
                {
                    var usbDevices = GetUSBDevices();

                    //list every USB device
                    foreach (var usbDevice in usbDevices)
                    {
                        
                        if(usbDevice.Name == USB_DEVICE_NAME)
                        {
                            VID = usbDevice.DeviceID.Substring(9, 4);
                            PID = usbDevice.DeviceID.Substring(18, 4);

                            if(USBClass.GetUSBDevice(uint.Parse(VID, System.Globalization.NumberStyles.AllowHexSpecifier), uint.Parse(PID, System.Globalization.NumberStyles.AllowHexSpecifier), ref ListOfUSBDeviceProperties, false))
                            {


                                //My Device is attached
                                lblNbUsbKeys.Text = "Number of found devices: " + ListOfUSBDeviceProperties.Count.ToString();
                                /*FoundDevicesComboBox.Items.Clear();
                                for (int i = 0; i < ListOfUSBDeviceProperties.Count; i++)
                                {
                                    FoundDevicesComboBox.Items.Add("Device " + i.ToString());
                                }
                                FoundDevicesComboBox.Enabled = (ListOfUSBDeviceProperties.Count > 1);
                                FoundDevicesComboBox.SelectedIndex = 0;*/

                                
                            }


                            Console.WriteLine("Device ID: {0}", usbDevice.DeviceID);
                        }
                    }

                    Console.Read();

                    foreach (DriveInfo drive in DriveInfo.GetDrives())
                    {
                        // if the device is an removable device (USB, external drive), add it to the list
                        if (drive.DriveType == DriveType.Removable) 
                        {
                            devices.Add(string.Format("({0}) {1}", drive.Name.Replace("\\", ""), drive.VolumeLabel));

                            //UsbKey usbKey = new UsbKey(drive.VolumeLabel, drive.id)
                            
                            //db.AddUsb(drive.VolumeLabel);
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
            if(devices.Count != lstDevices.Items.Count)
            {
                lstDevices.DataSource = null;
            }

            lstDevices.DataSource = devices;
        }

        private void Form1_FormClosing(object sender, FormClosingEventArgs e)
        {
            thread.Abort();
        }

        #endregion

        #region USB

        #endregion
    }
}

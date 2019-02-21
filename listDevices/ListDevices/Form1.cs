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
using System.Runtime.InteropServices;
using System.Management.Automation;
using System.Management.Automation.Runspaces;



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
            DriveInfo[] connectedDrives;
            string[] usbLocations;
            int usbPort;
            int usbRack;

            while(true)
            {
                devices.Clear();
              
                usbLocations = GetUsbLocation();
                //Array.Reverse(usbLocations, 0, usbLocations.Length);
                


                try
                {
                    for(int i = 0; i < usbLocations.Length-2; i++)
                    {
                        usbPort = System.Convert.ToInt32(usbLocations[i].Substring(6, 4)); //get the port n° of the USB key
                        usbRack = System.Convert.ToInt32(usbLocations[i].Substring(16, 4)); //get the rack n° of the USB key

                        i++;

                        devices.Add(string.Format("id : {0} - port : {1}, hub : {2}", usbLocations[i], usbPort, usbRack)); 

                        UsbKey usbKey = new UsbKey("", usbLocations[i], 0, DateTime.Now.ToString("yyyy-MM-dd HH:mm"), usbRack, usbPort);//create a new USB key 

                        db.AddUsbKey(usbKey); //try to add the USB key in DB
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
        /// Get all the usb keys locations ports and racks
        /// source : https://www.codeproject.com/Articles/18229/How-to-run-PowerShell-scripts-from-C
        /// </summary>
        /// <returns></returns>
        private string[] GetUsbLocation()
        {
            string[] locations;

            //insert your powershell script here
           // string script = "$TabDevicesId =  @(gwmi win32_USBHub | where { $_.name -like '*stockage*'}).PNPDeviceID; Foreach($valeur in $TabDevicesId) {(Get-ItemProperty -Path \"HKLM:\\SYSTEM\\CurrentControlSet\\Enum\\$valeur\" -Name LocationInformation).LocationInformation; }";
            string script = "$TabDevicesId =  @(gwmi win32_USBHub | where { $_.name -like '*stockage*'}).PNPDeviceID; Foreach($valeur in $TabDevicesId) {(Get-ItemProperty -Path \"HKLM:\\SYSTEM\\CurrentControlSet\\Enum\\$valeur\" -Name LocationInformation).LocationInformation; (Get-ItemProperty -Path \"HKLM:\\SYSTEM\\CurrentControlSet\\Enum\\$valeur\" -Name ContainerID).ContainerID;}";

            Runspace runspace = RunspaceFactory.CreateRunspace();

            runspace.Open();


            Pipeline pipeline = runspace.CreatePipeline();
            pipeline.Commands.AddScript(script);

            pipeline.Commands.Add("Out-String");

            Collection<PSObject> results = pipeline.Invoke();

            runspace.Close();

            StringBuilder stringBuilder = new StringBuilder();
            foreach (PSObject obj in results)
            {
                stringBuilder.AppendLine(obj.ToString());
            }

            return locations = stringBuilder.ToString().Split('\n');

            
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
                db.ResetLocation();
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
